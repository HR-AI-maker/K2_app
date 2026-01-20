<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\UserDocument;
use App\Models\MedicalInfo;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = auth()->user()->load('medicalInfo');

        return view('profile.edit', ['user' => $user]);
    }

    /**
     * Update the user's profile.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile(
            auth()->id(),
            $request->validated()
        );

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show documents management page.
     */
    public function documents()
    {
        $user = auth()->user();
        $documents = $user->documents()->get();

        // Group documents by type
        $documentsByType = $documents->groupBy('document_type');

        // Required document types
        $requiredTypes = [
            'cnic' => 'CNIC / ID Card',
            'passport' => 'Passport',
            'insurance' => 'Travel Insurance',
            'medical' => 'Medical Certificate',
        ];

        return view('profile.documents', [
            'user' => $user,
            'documents' => $documents,
            'documentsByType' => $documentsByType,
            'requiredTypes' => $requiredTypes,
        ]);
    }

    /**
     * Upload a new document.
     */
    public function uploadDocument(Request $request)
    {
        $validated = $request->validate([
            'document_type' => 'required|in:cnic,passport,visa,insurance,medical',
            'document_file' => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png',
        ]);

        try {
            $file = $request->file('document_file');
            $originalName = $file->getClientOriginalName();
            $fileName = auth()->id() . '_' . $validated['document_type'] . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Store the file
            $path = $file->storeAs("documents/" . auth()->id(), $fileName, 'local');

            // Create document record
            UserDocument::create([
                'user_id' => auth()->id(),
                'document_type' => $validated['document_type'],
                'document_path' => $path,
                'document_url' => asset('storage/' . $path),
            ]);

            return redirect()->route('profile.documents')
                ->with('success', 'Document uploaded successfully! Admin will verify it soon.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload document: ' . $e->getMessage());
        }
    }

    /**
     * Delete a document.
     */
    public function deleteDocument(UserDocument $document)
    {
        // Verify ownership
        if ($document->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        try {
            // Delete file if it exists
            if ($document->document_path && Storage::disk('local')->exists($document->document_path)) {
                Storage::disk('local')->delete($document->document_path);
            }

            $document->delete();

            return redirect()->back()
                ->with('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete document.');
        }
    }

    /**
     * Show medical information page.
     */
    public function medical()
    {
        $user = auth()->user();
        $medicalInfo = $user->medicalInfo ?? new MedicalInfo();

        return view('profile.medical', [
            'user' => $user,
            'medicalInfo' => $medicalInfo,
        ]);
    }

    /**
     * Update medical information.
     */
    public function updateMedical(Request $request)
    {
        $validated = $request->validate([
            'blood_type' => 'required|in:O+,O-,A+,A-,B+,B-,AB+,AB-',
            'allergies' => 'nullable|array',
            'allergies.*' => 'string|max:100',
            'medical_conditions' => 'nullable|array',
            'medical_conditions.*' => 'string|max:100',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'emergency_contact_relationship' => 'required|string|max:100',
            'insurance_provider' => 'required|string|max:255',
            'insurance_policy_number' => 'required|string|max:255',
            'insurance_expiry' => 'required|date|after:today',
        ]);

        try {
            $user = auth()->user();

            // Get or create medical info
            $medicalInfo = $user->medicalInfo ?? new MedicalInfo();
            $medicalInfo->user_id = $user->id;
            $medicalInfo->fill($validated);
            $medicalInfo->save();

            return redirect()->back()
                ->with('success', 'Medical information updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update medical information.');
        }
    }

    /**
     * Show membership history page.
     */
    public function membership()
    {
        $user = auth()->user();
        $membershipHistory = $user->membershipHistory()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.membership', [
            'user' => $user,
            'membershipHistory' => $membershipHistory,
        ]);
    }

    /**
     * Show badges page.
     */
    public function badges()
    {
        $user = auth()->user()->load('badges');

        return view('profile.badges', ['user' => $user]);
    }
}
