<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VendorsController extends Controller
{
    /**
     * Display a list of vendors.
     */
    public function index(Request $request)
    {
        $query = Vendor::query();

        // Filter by status
        $status = $request->input('status', 'all');
        if ($status === 'pending') {
            $query->where('status', 'pending');
        } elseif ($status === 'verified') {
            $query->where('status', 'verified');
        } elseif ($status === 'suspended') {
            $query->where('status', 'suspended');
        }

        // Filter by business type
        if ($businessType = $request->input('business_type')) {
            $query->where('business_type', $businessType);
        }

        // Search by business name or contact
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Load relationships
        $vendors = $query->with('verifiedBy')
                        ->paginate(15);

        // Calculate statistics
        $stats = [
            'pending' => Vendor::where('status', 'pending')->count(),
            'verified' => Vendor::where('status', 'verified')->count(),
            'suspended' => Vendor::where('status', 'suspended')->count(),
            'total' => Vendor::count(),
        ];

        $currentStatus = $request->input('status', 'all');

        return view('admin.vendors.index', [
            'vendors' => $vendors,
            'stats' => $stats,
            'currentStatus' => $currentStatus,
            'currentBusinessType' => $request->input('business_type'),
        ]);
    }

    /**
     * Show the form for creating a new vendor.
     */
    public function create()
    {
        return view('admin.vendors.create');
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:200'],
            'contact_person' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'business_type' => ['required', 'in:guide,transport,lodging,equipment,other'],
            'description' => ['required', 'string', 'min:20'],
            'is_certified' => ['sometimes', 'boolean'],
            'certification_details' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $vendor = Vendor::create([
                'business_name' => $validated['business_name'],
                'contact_person' => $validated['contact_person'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'business_type' => $validated['business_type'],
                'description' => $validated['description'],
                'is_certified' => $validated['is_certified'] ?? false,
                'certification_details' => $validated['certification_details'],
                'status' => 'pending',
            ]);

            return redirect()
                ->route('admin.vendors.show', $vendor)
                ->with('success', 'Vendor created successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to create vendor. Please try again.');
        }
    }

    /**
     * Display the specified vendor.
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('verifiedBy');

        return view('admin.vendors.show', [
            'vendor' => $vendor,
        ]);
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit(Vendor $vendor)
    {
        return view('admin.vendors.edit', [
            'vendor' => $vendor,
        ]);
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:200'],
            'contact_person' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:500'],
            'business_type' => ['required', 'in:guide,transport,lodging,equipment,other'],
            'description' => ['required', 'string', 'min:20'],
            'is_certified' => ['sometimes', 'boolean'],
            'certification_details' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $vendor->update($validated);

            return redirect()
                ->route('admin.vendors.show', $vendor)
                ->with('success', 'Vendor updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Failed to update vendor. Please try again.');
        }
    }

    /**
     * Verify a vendor.
     */
    public function verify(Request $request, Vendor $vendor)
    {
        if ($vendor->status === 'verified') {
            return back()->with('error', 'Vendor is already verified.');
        }

        try {
            $vendor->update([
                'status' => 'verified',
                'verified_by' => auth()->id(),
                'verified_at' => now(),
            ]);

            return back()->with('success', "Vendor '{$vendor->business_name}' verified successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to verify vendor. Please try again.');
        }
    }

    /**
     * Create vendor login credentials.
     */
    public function createCredentials(Request $request, Vendor $vendor)
    {
        if ($vendor->status !== 'verified') {
            return back()->with('error', 'Only verified vendors can create credentials.');
        }

        if ($vendor->vendor_user_id) {
            return back()->with('error', 'This vendor already has login credentials.');
        }

        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        try {
            // Create user account
            $user = User::create([
                'first_name' => explode(' ', $vendor->contact_person)[0],
                'last_name' => collect(explode(' ', $vendor->contact_person))->slice(1)->join(' ') ?: 'User',
                'email' => $validated['email'],
                'phone' => $vendor->phone,
                'password' => bcrypt($validated['password']),
                'user_type' => 'local',
                'membership_tier' => 'standard',
                'membership_status' => 'active',
                'is_admin' => false,
            ]);

            // Link to vendor
            $vendor->update([
                'vendor_user_id' => $user->id,
                'can_sell' => true,
            ]);

            return back()->with('success', "Vendor credentials created successfully. Email: {$validated['email']}");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create credentials. Please try again.');
        }
    }

    /**
     * Suspend a vendor.
     */
    public function suspend(Request $request, Vendor $vendor)
    {
        if ($vendor->status === 'suspended') {
            return back()->with('error', 'Vendor is already suspended.');
        }

        try {
            $vendor->update([
                'status' => 'suspended',
            ]);

            return back()->with('success', "Vendor '{$vendor->business_name}' suspended.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to suspend vendor. Please try again.');
        }
    }

    /**
     * Reactivate a suspended vendor.
     */
    public function reactivate(Request $request, Vendor $vendor)
    {
        if ($vendor->status !== 'suspended') {
            return back()->with('error', 'Only suspended vendors can be reactivated.');
        }

        try {
            $vendor->update([
                'status' => 'verified',
            ]);

            return back()->with('success', "Vendor '{$vendor->business_name}' reactivated.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reactivate vendor. Please try again.');
        }
    }

    /**
     * Delete a vendor.
     */
    public function destroy(Request $request, Vendor $vendor)
    {
        try {
            $vendorName = $vendor->business_name;
            $vendor->delete();

            return redirect()
                ->route('admin.vendors.index')
                ->with('success', "Vendor '{$vendorName}' deleted successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete vendor. Please try again.');
        }
    }

    /**
     * Update vendor rating.
     */
    public function updateRating(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);

        try {
            $vendor->update([
                'rating' => $validated['rating'],
            ]);

            return back()->with('success', "Vendor rating updated to {$validated['rating']} stars.");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update rating. Please try again.');
        }
    }
}
