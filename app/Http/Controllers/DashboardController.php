<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\EventService;
use App\Services\MembershipService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userService;
    protected $eventService;
    protected $membershipService;

    public function __construct(
        UserService $userService,
        EventService $eventService,
        MembershipService $membershipService
    ) {
        $this->userService = $userService;
        $this->eventService = $eventService;
        $this->membershipService = $membershipService;
    }

    /**
     * Display the user dashboard.
     */
    public function index()
    {
        $user = auth()->user()->load([
            'documents',
            'medicalInfo',
            'membershipHistory',
            'eventRegistrations.event',
            'expeditionApplications.expedition',
            'communityPosts',
            'badges',
        ]);

        // Calculate profile completion percentage
        $profileCompleteness = $this->calculateProfileCompleteness($user);

        // Get upcoming registered events
        $upcomingEvents = $user->eventRegistrations()
            ->whereHas('event', function ($query) {
                $query->where('start_date', '>=', now())
                      ->where('status', 'published');
            })
            ->with('event')
            ->where('status', 'registered')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get expedition applications with status
        $expeditionApps = $user->expeditionApplications()
            ->with('expedition')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get pending applications
        $pendingApps = $expeditionApps->where('status', 'pending')->count();
        $approvedApps = $expeditionApps->where('status', 'approved')->count();
        $rejectedApps = $expeditionApps->where('status', 'rejected')->count();

        // Check document verification status
        $documents = $user->documents()->get();
        $verifiedDocs = $documents->where('verified_at', '!=', null)->count();
        $totalDocs = $documents->count();

        // Get membership information
        $latestMembership = $user->membershipHistory()
            ->latest('expires_at')
            ->first();

        $membershipExpired = $this->membershipService->isMembershipExpired($user->id);
        $daysUntilExpiry = null;
        if ($latestMembership && !$membershipExpired) {
            $daysUntilExpiry = now()->diffInDays($latestMembership->expires_at);
        }

        // Get statistics
        $stats = [
            'events_registered' => $user->eventRegistrations()
                ->where('status', 'registered')
                ->count(),
            'expeditions_applied' => $user->expeditionApplications()->count(),
            'community_posts' => $user->communityPosts()->count(),
            'badges_earned' => $user->badges()->count(),
            'documents_verified' => $verifiedDocs,
            'documents_total' => $totalDocs,
        ];

        // Get recent activities
        $activities = $this->getRecentActivities($user);

        return view('dashboard', [
            'user' => $user,
            'profileCompleteness' => $profileCompleteness,
            'upcomingEvents' => $upcomingEvents,
            'expeditionApps' => $expeditionApps,
            'stats' => $stats,
            'latestMembership' => $latestMembership,
            'membershipExpired' => $membershipExpired,
            'daysUntilExpiry' => $daysUntilExpiry,
            'pendingApps' => $pendingApps,
            'approvedApps' => $approvedApps,
            'rejectedApps' => $rejectedApps,
            'activities' => $activities,
        ]);
    }

    /**
     * Calculate profile completeness percentage.
     */
    private function calculateProfileCompleteness($user): int
    {
        $totalFields = 0;
        $completedFields = 0;

        // Basic info
        $basicInfoFields = [
            'first_name' => !empty($user->first_name),
            'last_name' => !empty($user->last_name),
            'phone' => !empty($user->phone),
            'address' => !empty($user->address),
            'climbing_discipline' => !empty($user->climbing_discipline),
        ];

        $totalFields += count($basicInfoFields);
        $completedFields += count(array_filter($basicInfoFields));

        // Medical info
        $medicalFields = [
            'blood_type' => $user->medicalInfo && !empty($user->medicalInfo->blood_type),
            'allergies' => $user->medicalInfo && !empty($user->medicalInfo->allergies),
            'emergency_contact' => $user->medicalInfo && !empty($user->medicalInfo->emergency_contact_name),
            'insurance' => $user->medicalInfo && !empty($user->medicalInfo->insurance_provider),
        ];

        $totalFields += count($medicalFields);
        $completedFields += count(array_filter($medicalFields));

        // Documents
        $documentsFields = [
            'documents' => $user->documents()->count() > 0,
        ];

        $totalFields += count($documentsFields);
        $completedFields += count(array_filter($documentsFields));

        // Membership
        $membershipFields = [
            'membership' => $user->isMember(),
        ];

        $totalFields += count($membershipFields);
        $completedFields += count(array_filter($membershipFields));

        return $totalFields > 0 ? (int) (($completedFields / $totalFields) * 100) : 0;
    }

    /**
     * Get recent activities for timeline.
     */
    private function getRecentActivities($user)
    {
        $activities = [];

        // Recent event registrations
        $eventRegs = $user->eventRegistrations()
            ->with('event')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($eventRegs as $reg) {
            $activities[] = [
                'type' => 'event_registration',
                'title' => 'Registered for event',
                'description' => $reg->event->title,
                'date' => $reg->created_at,
                'icon' => '📅',
                'status' => $reg->status,
            ];
        }

        // Recent expedition applications
        $expApps = $user->expeditionApplications()
            ->with('expedition')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($expApps as $app) {
            $activities[] = [
                'type' => 'expedition_application',
                'title' => 'Applied for expedition',
                'description' => $app->expedition->title,
                'date' => $app->created_at,
                'icon' => '🏔️',
                'status' => $app->status,
            ];
        }

        // Recent community posts
        $posts = $user->communityPosts()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($posts as $post) {
            $activities[] = [
                'type' => 'community_post',
                'title' => 'Posted in community',
                'description' => $post->title ?? 'Community post',
                'date' => $post->created_at,
                'icon' => '📝',
                'status' => $post->status ?? 'published',
            ];
        }

        // Sort by date descending
        usort($activities, function ($a, $b) {
            return $b['date']->timestamp <=> $a['date']->timestamp;
        });

        return array_slice($activities, 0, 10);
    }
}
