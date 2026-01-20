<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocument;
use App\Services\MembershipService;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    /**
     * Display a list of documents pending verification.
     */
    public function index(Request $request)
    {
        $query = UserDocument::query();

        // Filter by verification status
        $status = $request->input('status', 'pending');
        if ($status === 'pending') {
            $query->whereNull('verified_at')
                  ->whereNull('rejection_date');
        } elseif ($status === 'verified') {
            $query->whereNotNull('verified_at');
        } elseif ($status === 'rejected') {
            $query->whereNotNull('rejection_date');
        }

        // Filter by document type
        if ($documentType = $request->input('document_type')) {
            $query->where('document_type', $documentType);
        }

        // Search by user
        if ($search = $request->input('search')) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Sort options
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Load user relationships
        $documents = $query->with('user', 'verifiedBy')
                          ->paginate(15);

        // Get statistics
        $stats = [
            'total' => UserDocument::count(),
            'pending' => UserDocument::whereNull('verified_at')->whereNull('rejection_date')->count(),
            'verified' => UserDocument::whereNotNull('verified_at')->count(),
            'rejected' => UserDocument::whereNotNull('rejection_date')->count(),
        ];

        return view('admin.documents.index', [
            'documents' => $documents,
            'stats' => $stats,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Display a specific document with details and verification form.
     */
    public function show(UserDocument $document)
    {
        $document->load('user.documents', 'user.medicalInfo', 'user.membershipHistory', 'verifiedBy');

        // Get user's document status
        $userDocuments = $document->user->documents()
            ->orderBy('document_type')
            ->get()
            ->groupBy('document_type');

        // Required document types
        $requiredTypes = ['cnic', 'passport', 'insurance', 'medical'];
        $allDocumentsVerified = true;

        foreach ($requiredTypes as $type) {
            $typeDoc = $userDocuments->get($type)?->first();
            if (!$typeDoc || !$typeDoc->verified_at) {
                $allDocumentsVerified = false;
                break;
            }
        }

        // Get user's membership info
        $latestMembership = $document->user->membershipHistory()
            ->latest('created_at')
            ->first();

        return view('admin.documents.show', [
            'document' => $document,
            'user' => $document->user,
            'userDocuments' => $userDocuments,
            'requiredTypes' => $requiredTypes,
            'allDocumentsVerified' => $allDocumentsVerified,
            'latestMembership' => $latestMembership,
        ]);
    }

    /**
     * Verify (approve) a document.
     */
    public function verify(Request $request, UserDocument $document)
    {
        // Prevent re-verification of already verified documents
        if ($document->verified_at !== null) {
            return redirect()->back()->with('warning', 'This document is already verified.');
        }

        try {
            // Update document as verified
            $document->update([
                'verified_at' => now(),
                'verified_by' => auth()->id(),
            ]);

            // Clear any previous rejection
            if ($document->rejection_reason) {
                $document->update(['rejection_reason' => null]);
            }

            // Check if all required documents are now verified
            $this->checkAndVerifyMembership($document->user);

            return redirect()->back()->with('success', 'Document verified successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to verify document: ' . $e->getMessage());
        }
    }

    /**
     * Reject a document.
     */
    public function reject(Request $request, UserDocument $document)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Prevent re-rejection
        if ($document->rejection_date !== null) {
            return redirect()->back()->with('warning', 'This document is already rejected.');
        }

        try {
            // Clear verification if it was verified
            if ($document->verified_at) {
                $document->update(['verified_at' => null, 'verified_by' => null]);
            }

            // Mark as rejected
            $document->update([
                'rejection_reason' => $validated['rejection_reason'],
                'rejection_date' => now(),
            ]);

            return redirect()->back()->with('success', 'Document rejected. User has been notified.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to reject document: ' . $e->getMessage());
        }
    }

    /**
     * Clear rejection and reopen for resubmission.
     */
    public function clearRejection(UserDocument $document)
    {
        if ($document->rejection_date === null) {
            return redirect()->back()->with('warning', 'This document is not rejected.');
        }

        try {
            $document->update([
                'rejection_reason' => null,
                'rejection_date' => null,
            ]);

            return redirect()->back()->with('success', 'Rejection cleared. User can resubmit document.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear rejection.');
        }
    }

    /**
     * Check if all required documents are verified and auto-verify membership.
     */
    private function checkAndVerifyMembership(User $user)
    {
        $requiredTypes = ['cnic', 'passport', 'insurance', 'medical'];
        $allVerified = true;

        foreach ($requiredTypes as $type) {
            $doc = $user->documents()
                ->where('document_type', $type)
                ->first();

            if (!$doc || !$doc->verified_at) {
                $allVerified = false;
                break;
            }
        }

        // If all documents verified and user not already a member, verify membership
        if ($allVerified && $user->membership_status !== 'active') {
            $this->membershipService->verifyMembership($user->id, 'standard');
        }
    }

    /**
     * Bulk verify documents.
     */
    public function bulkVerify(Request $request)
    {
        $documentIds = $request->input('document_ids', []);

        if (empty($documentIds)) {
            return redirect()->back()->with('warning', 'No documents selected.');
        }

        try {
            $documents = UserDocument::whereIn('id', $documentIds)
                ->whereNull('verified_at')
                ->get();

            foreach ($documents as $document) {
                $document->update([
                    'verified_at' => now(),
                    'verified_by' => auth()->id(),
                ]);

                // Check and verify membership for each user
                $this->checkAndVerifyMembership($document->user);
            }

            return redirect()->back()->with('success', count($documents) . ' documents verified successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to verify documents: ' . $e->getMessage());
        }
    }
}
