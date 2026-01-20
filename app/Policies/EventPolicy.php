<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    /**
     * Determine if the user can view any events.
     */
    public function viewAny(User $user): bool
    {
        return true; // Public can view events
    }

    /**
     * Determine if the user can view the event.
     */
    public function view(User $user, Event $event): bool
    {
        return $event->status === 'published' || $user->isAdmin();
    }

    /**
     * Determine if the user can create events.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the event.
     */
    public function update(User $user, Event $event): bool
    {
        return $user->isAdmin() || $user->id === $event->created_by;
    }

    /**
     * Determine if the user can delete the event.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can register for the event.
     */
    public function register(User $user, Event $event): bool
    {
        return $event->status === 'published' && $event->start_date->isFuture();
    }
}
