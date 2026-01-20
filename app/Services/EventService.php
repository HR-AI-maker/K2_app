<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Database\Eloquent\Model;

class EventService extends BaseService
{
    protected function getModel(): Model
    {
        return new Event();
    }

    /**
     * Get upcoming events.
     */
    public function getUpcomingEvents($limit = 10)
    {
        return $this->model
            ->where('status', 'published')
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->limit($limit)
            ->get();
    }

    /**
     * Get events by region.
     */
    public function getEventsByRegion($region)
    {
        return $this->model
            ->where('region', $region)
            ->where('status', 'published')
            ->get();
    }

    /**
     * Register a user for an event.
     */
    public function registerUser($eventId, $userId, $paymentMethod = null)
    {
        $event = $this->findOrFail($eventId);

        // Check if already registered
        $existing = EventRegistration::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();

        if ($existing && $existing->status !== 'cancelled') {
            throw new \Exception('User already registered for this event');
        }

        // Check capacity
        $registeredCount = EventRegistration::where('event_id', $eventId)
            ->where('status', 'registered')
            ->count();

        $status = $registeredCount < $event->max_participants ? 'registered' : 'waitlisted';

        return EventRegistration::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'status' => $status,
            'payment_method' => $paymentMethod,
            'registered_at' => now(),
        ]);
    }

    /**
     * Approve an event registration.
     */
    public function approveRegistration($registrationId)
    {
        $registration = EventRegistration::findOrFail($registrationId);
        $registration->update(['status' => 'registered']);

        return $registration;
    }

    /**
     * Get event statistics.
     */
    public function getEventStats($eventId)
    {
        $event = $this->findOrFail($eventId);

        return [
            'total_registrations' => EventRegistration::where('event_id', $eventId)->count(),
            'confirmed' => EventRegistration::where('event_id', $eventId)->where('status', 'registered')->count(),
            'waitlisted' => EventRegistration::where('event_id', $eventId)->where('status', 'waitlisted')->count(),
            'cancelled' => EventRegistration::where('event_id', $eventId)->where('status', 'cancelled')->count(),
        ];
    }
}
