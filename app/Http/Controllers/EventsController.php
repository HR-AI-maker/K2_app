<?php

namespace App\Http\Controllers;

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
     * Display a listing of published events.
     */
    public function index(Request $request)
    {
        $query = Event::where('status', 'published');

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

        // Filter by region
        if ($region = $request->input('region')) {
            $query->where('region', $region);
        }

        // Filter: upcoming/past
        if ($filter = $request->input('filter')) {
            if ($filter === 'upcoming') {
                $query->where('start_date', '>=', now());
            } elseif ($filter === 'past') {
                $query->where('start_date', '<', now());
            }
        } else {
            // Default to upcoming events
            $query->where('start_date', '>=', now());
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'start_date');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginate
        $events = $query->paginate(12);

        // Get distinct regions for filter
        $regions = Event::where('status', 'published')
            ->distinct()
            ->pluck('region')
            ->sort()
            ->values();

        return view('events.index', [
            'events' => $events,
            'regions' => $regions,
        ]);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        // Only show published events to public
        if ($event->status !== 'published') {
            abort(404);
        }

        $event->load(['registrations' => function ($query) {
            $query->where('status', 'registered');
        }, 'creator']);

        // Get registration stats
        $stats = $this->eventService->getEventStats($event->id);

        // Check if user is already registered
        $userRegistration = null;
        if (auth()->check()) {
            $userRegistration = EventRegistration::where('event_id', $event->id)
                ->where('user_id', auth()->id())
                ->first();
        }

        // Check availability
        $availableSlots = max(0, $event->max_participants - $stats['confirmed']);
        $isFull = $availableSlots === 0;

        return view('events.show', [
            'event' => $event,
            'stats' => $stats,
            'availableSlots' => $availableSlots,
            'isFull' => $isFull,
            'userRegistration' => $userRegistration,
        ]);
    }

    /**
     * Store a new event registration.
     */
    public function storeRegistration(Request $request, Event $event)
    {
        // Verify event is published
        if ($event->status !== 'published') {
            return redirect()->back()->with('error', 'This event is not available for registration.');
        }

        // Check if user is already registered
        $existing = EventRegistration::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($existing) {
            return redirect()->back()->with('warning', 'You are already registered for this event.');
        }

        try {
            $registration = $this->eventService->registerUser($event->id, auth()->id());

            $message = $registration->status === 'registered'
                ? 'You have successfully registered for the event!'
                : 'You have been added to the waitlist.';

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Global search across events, expeditions, and vendors.
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $results = [];

        if (strlen($query) >= 2) {
            // Search events
            $events = Event::where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('location', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get();

            // Search expeditions
            $expeditions = \App\Models\Expedition::whereIn('status', ['open', 'closed'])
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('location', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get();

            // Search vendors
            $vendors = \App\Models\Vendor::where('status', '!=', 'suspended')
                ->where(function ($q) use ($query) {
                    $q->where('business_name', 'like', "%{$query}%")
                      ->orWhere('address', 'like', "%{$query}%");
                })
                ->limit(5)
                ->get();

            $results = [
                'events' => $events,
                'expeditions' => $expeditions,
                'vendors' => $vendors,
                'query' => $query,
            ];
        }

        return view('search', $results);
    }
}
