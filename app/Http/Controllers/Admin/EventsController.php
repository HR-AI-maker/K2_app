<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Display list of all events with filtering and statistics.
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Search by title, location, region
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by event type
        if ($eventType = $request->input('event_type')) {
            $query->where('event_type', $eventType);
        }

        // Filter by status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filter by region
        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        // Filter by date range
        if ($startDate = $request->input('start_date')) {
            $query->whereDate('start_date', '>=', $startDate);
        }

        if ($endDate = $request->input('end_date')) {
            $query->whereDate('end_date', '<=', $endDate);
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $events = $query->paginate(15);

        // Get statistics
        $stats = [
            'total' => Event::count(),
            'published' => Event::where('status', 'published')->count(),
            'draft' => Event::where('status', 'draft')->count(),
            'upcoming' => Event::where('status', 'published')
                ->where('start_date', '>=', now())
                ->count(),
            'cancelled' => Event::where('status', 'cancelled')->count(),
            'completed' => Event::where('status', 'completed')->count(),
        ];

        // Get distinct regions for filter
        $regions = Event::distinct()->pluck('region')->sort()->values();

        return view('admin.events.index', [
            'events' => $events,
            'stats' => $stats,
            'regions' => $regions,
        ]);
    }

    /**
     * Show the form to create a new event.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:championship,training,expedition,meetup',
            'region' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'price_member' => 'required|numeric|min:0',
            'price_nonmember' => 'required|numeric|min:0',
            'eligibility_requirements' => 'nullable|array',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';
        $validated['current_participants'] = 0;

        $event = Event::create($validated);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load(['registrations.user', 'creator']);

        // Get registration statistics
        $stats = $this->eventService->getEventStats($event->id);

        // Get registrations grouped by status
        $registrations = EventRegistration::where('event_id', $event->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('status');

        return view('admin.events.show', [
            'event' => $event,
            'stats' => $stats,
            'registrations' => $registrations,
        ]);
    }

    /**
     * Show the form to edit the specified event.
     */
    public function edit(Event $event)
    {
        return view('admin.events.edit', ['event' => $event]);
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:championship,training,expedition,meetup',
            'region' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'max_participants' => 'required|integer|min:1',
            'price_member' => 'required|numeric|min:0',
            'price_nonmember' => 'required|numeric|min:0',
            'eligibility_requirements' => 'nullable|array',
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event updated successfully!');
    }

    /**
     * Soft delete the specified event.
     */
    public function destroy(Event $event)
    {
        $title = $event->title;
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', "Event '{$title}' deleted successfully!");
    }

    /**
     * Publish an event (change status to published).
     */
    public function publish(Event $event)
    {
        $event->update(['status' => 'published']);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event published successfully!');
    }

    /**
     * Cancel an event (change status to cancelled).
     */
    public function cancel(Event $event)
    {
        $event->update(['status' => 'cancelled']);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event cancelled successfully!');
    }

    /**
     * Mark an event as completed.
     */
    public function complete(Event $event)
    {
        $event->update(['status' => 'completed']);

        return redirect()->route('admin.events.show', $event)->with('success', 'Event marked as completed!');
    }
}
