<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expedition;
use App\Models\ExpeditionApplication;
use Illuminate\Http\Request;

class ExpeditionsController extends Controller
{
    /**
     * Display a list of all expeditions.
     */
    public function index(Request $request)
    {
        $query = Expedition::query();

        // Search by title, location, region
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by difficulty
        if ($difficulty = $request->input('difficulty')) {
            $query->where('difficulty_level', $difficulty);
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $expeditions = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => Expedition::count(),
            'open' => Expedition::where('status', 'open')->count(),
            'closed' => Expedition::where('status', 'closed')->count(),
            'planning' => Expedition::where('status', 'planning')->count(),
            'completed' => Expedition::where('status', 'completed')->count(),
            'cancelled' => Expedition::where('status', 'cancelled')->count(),
        ];

        return view('admin.expeditions.index', [
            'expeditions' => $expeditions,
            'stats' => $stats,
        ]);
    }

    /**
     * Show the form to create a new expedition.
     */
    public function create()
    {
        return view('admin.expeditions.create');
    }

    /**
     * Store a newly created expedition.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,expert',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'permit_required' => 'boolean',
            'permit_details' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'planning';

        $expedition = Expedition::create($validated);

        return redirect()->route('admin.expeditions.show', $expedition)
            ->with('success', 'Expedition created successfully!');
    }

    /**
     * Display the specified expedition.
     */
    public function show(Expedition $expedition)
    {
        $expedition->load(['applications.user', 'creator']);

        // Get application statistics
        $applicationStats = [
            'total' => $expedition->applications()->count(),
            'pending' => $expedition->applications()->where('status', 'pending')->count(),
            'approved' => $expedition->applications()->where('status', 'approved')->count(),
            'rejected' => $expedition->applications()->where('status', 'rejected')->count(),
            'cancelled' => $expedition->applications()->where('status', 'cancelled')->count(),
        ];

        // Get applications grouped by status
        $applications = ExpeditionApplication::where('expedition_id', $expedition->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        return view('admin.expeditions.show', [
            'expedition' => $expedition,
            'applicationStats' => $applicationStats,
            'applications' => $applications,
        ]);
    }

    /**
     * Show the form to edit the expedition.
     */
    public function edit(Expedition $expedition)
    {
        return view('admin.expeditions.edit', ['expedition' => $expedition]);
    }

    /**
     * Update the specified expedition.
     */
    public function update(Request $request, Expedition $expedition)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced,expert',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'permit_required' => 'boolean',
            'permit_details' => 'nullable|string',
        ]);

        $expedition->update($validated);

        return redirect()->route('admin.expeditions.show', $expedition)
            ->with('success', 'Expedition updated successfully!');
    }

    /**
     * Delete the specified expedition.
     */
    public function destroy(Expedition $expedition)
    {
        $title = $expedition->title;
        $expedition->delete();

        return redirect()->route('admin.expeditions.index')
            ->with('success', "Expedition '{$title}' deleted successfully!");
    }

    /**
     * Change expedition status to open.
     */
    public function open(Expedition $expedition)
    {
        $expedition->update(['status' => 'open']);

        return redirect()->back()->with('success', 'Expedition is now open for applications!');
    }

    /**
     * Change expedition status to closed.
     */
    public function close(Expedition $expedition)
    {
        $expedition->update(['status' => 'closed']);

        return redirect()->back()->with('success', 'Expedition applications are now closed!');
    }

    /**
     * Mark expedition as completed.
     */
    public function complete(Expedition $expedition)
    {
        $expedition->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Expedition marked as completed!');
    }

    /**
     * Cancel expedition.
     */
    public function cancel(Expedition $expedition)
    {
        $expedition->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', 'Expedition cancelled!');
    }

    /**
     * Display all applications for a specific expedition.
     */
    public function applications(Request $request, Expedition $expedition)
    {
        $query = $expedition->applications();

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Search by user
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $applications = $query
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get statistics
        $stats = [
            'pending' => $expedition->applications()->where('status', 'pending')->count(),
            'approved' => $expedition->applications()->where('status', 'approved')->count(),
            'rejected' => $expedition->applications()->where('status', 'rejected')->count(),
        ];

        return view('admin.expeditions.applications', [
            'expedition' => $expedition,
            'applications' => $applications,
            'stats' => $stats,
        ]);
    }

    /**
     * Approve an expedition application.
     */
    public function approveApplication(ExpeditionApplication $application)
    {
        $application->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Application approved successfully!');
    }

    /**
     * Reject an expedition application.
     */
    public function rejectApplication(Request $request, ExpeditionApplication $application)
    {
        $validated = $request->validate([
            'rejected_reason' => 'required|string|max:255',
        ]);

        $application->update([
            'status' => 'rejected',
            'rejected_reason' => $validated['rejected_reason'],
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Application rejected!');
    }
}
