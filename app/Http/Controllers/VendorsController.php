<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    /**
     * Display a listing of verified vendors.
     */
    public function index(Request $request)
    {
        $query = Vendor::where('status', 'verified');

        // Filter by business type
        if ($businessType = $request->input('business_type')) {
            $query->where('business_type', $businessType);
        }

        // Filter by region/location
        if ($region = $request->input('region')) {
            $query->where('address', 'like', "%{$region}%");
        }

        // Search by business name or contact person
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'rating');
        if ($sortBy === 'rating') {
            $query->orderBy('rating', 'desc');
        } elseif ($sortBy === 'bookings') {
            $query->orderBy('total_bookings', 'desc');
        } elseif ($sortBy === 'name') {
            $query->orderBy('business_name', 'asc');
        } else {
            $query->orderBy('verified_at', 'desc');
        }

        // Paginate
        $vendors = $query->with('verifiedBy')->paginate(12);

        // Get distinct regions for filter
        $regions = Vendor::where('status', 'verified')
            ->distinct()
            ->pluck('address')
            ->filter()
            ->sort()
            ->values();

        return view('vendors.index', [
            'vendors' => $vendors,
            'regions' => $regions,
            'currentBusinessType' => $request->input('business_type'),
            'currentRegion' => $request->input('region'),
            'currentSearch' => $request->input('search'),
        ]);
    }

    /**
     * Display the specified vendor.
     */
    public function show(Vendor $vendor)
    {
        // Only show verified vendors to public
        if ($vendor->status !== 'verified') {
            abort(404);
        }

        $vendor->load('verifiedBy');

        return view('vendors.show', [
            'vendor' => $vendor,
        ]);
    }
}
