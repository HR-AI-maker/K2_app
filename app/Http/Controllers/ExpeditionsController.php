<?php

namespace App\Http\Controllers;

use App\Models\Expedition;
use App\Models\ExpeditionApplication;
use Illuminate\Http\Request;

class ExpeditionsController extends Controller
{
    /**
     * Display a listing of open expeditions.
     */
    public function index(Request $request)
    {
        $query = Expedition::whereIn('status', ['open', 'closed'])
            ->where('end_date', '>=', now());

        // Search by title, location, region
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by difficulty
        if ($difficulty = $request->input('difficulty')) {
            $query->where('difficulty_level', $difficulty);
        }

        // Filter by region
        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        // Filter: open only
        if ($request->input('status') === 'open') {
            $query->where('status', 'open');
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'start_date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $expeditions = $query->paginate(12);

        // Get distinct regions and difficulty levels for filters
        $regions = Expedition::whereIn('status', ['open', 'closed'])
            ->distinct()
            ->pluck('region')
            ->sort()
            ->values();

        return view('expeditions.index', [
            'expeditions' => $expeditions,
            'regions' => $regions,
        ]);
    }

    /**
     * Display the specified expedition.
     */
    public function show(Expedition $expedition)
    {
        // Only show open/closed expeditions
        if (!in_array($expedition->status, ['open', 'closed'])) {
            abort(404);
        }

        $expedition->load(['applications' => function ($query) {
            $query->where('status', 'approved');
        }, 'creator']);

        // Get application count
        $approvedCount = $expedition->applications()->where('status', 'approved')->count();

        // Check if user has already applied
        $userApplication = null;
        if (auth()->check()) {
            $userApplication = ExpeditionApplication::where('expedition_id', $expedition->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        // Check availability
        $availableSlots = max(0, $expedition->max_participants - $approvedCount);
        $isFull = $availableSlots === 0 && $expedition->status === 'open';

        return view('expeditions.show', [
            'expedition' => $expedition,
            'approvedCount' => $approvedCount,
            'availableSlots' => $availableSlots,
            'isFull' => $isFull,
            'userApplication' => $userApplication,
        ]);
    }

    /**
     * Show the form to apply for an expedition.
     */
    public function create(Expedition $expedition)
    {
        // Only allow application to open expeditions
        if ($expedition->status !== 'open') {
            return redirect()->back()->with('error', 'This expedition is not accepting applications.');
        }

        // Check if user already applied
        if (auth()->check()) {
            $existing = ExpeditionApplication::where('expedition_id', $expedition->id)
                ->where('user_id', auth()->id())
                ->first();

            if ($existing) {
                return redirect()->route('expeditions.show', $expedition)
                    ->with('warning', 'You have already applied for this expedition.');
            }
        }

        return view('expeditions.apply', ['expedition' => $expedition]);
    }

    /**
     * Store a new expedition application.
     */
    public function store(Request $request, Expedition $expedition)
    {
        // Verify expedition is accepting applications
        if ($expedition->status !== 'open') {
            return redirect()->back()->with('error', 'This expedition is not accepting applications.');
        }

        // Check if already applied
        $existing = ExpeditionApplication::where('expedition_id', $expedition->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            return redirect()->back()->with('warning', 'You have already applied for this expedition.');
        }

        // Validate input
        $validated = $request->validate([
            'experience_level' => 'required|in:beginner,intermediate,advanced,expert',
            'application_notes' => 'required|string|max:1000',
        ]);

        try {
            $application = ExpeditionApplication::create([
                'expedition_id' => $expedition->id,
                'user_id' => auth()->id(),
                'experience_level' => $validated['experience_level'],
                'application_notes' => $validated['application_notes'],
                'status' => 'pending',
            ]);

            return redirect()->route('expeditions.show', $expedition)
                ->with('success', 'Your application has been submitted successfully! Admins will review it soon.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while submitting your application.');
        }
    }
}
