<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\ExpeditionsController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MembersController;
use App\Http\Controllers\Admin\DocumentsController;
use App\Http\Controllers\Admin\EventsController as AdminEventsController;
use App\Http\Controllers\Admin\ExpeditionsController as AdminExpeditionsController;
use App\Http\Controllers\Admin\CommunityController as AdminCommunityController;
use App\Http\Controllers\Admin\VendorsController as AdminVendorsController;
use App\Http\Controllers\Admin\BadgesController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public events
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventsController::class, 'index'])->name('index');
    Route::get('/{event}', [EventsController::class, 'show'])->name('show');
});

// Public expeditions
Route::prefix('expeditions')->name('expeditions.')->group(function () {
    Route::get('/', [ExpeditionsController::class, 'index'])->name('index');
    Route::get('/{expedition}', [ExpeditionsController::class, 'show'])->name('show');
});

// Public community
Route::prefix('community')->name('community.')->group(function () {
    Route::get('/', [CommunityController::class, 'index'])->name('index');
    Route::get('/{post}', [CommunityController::class, 'show'])->name('show');
});

// Public vendors
Route::prefix('vendors')->name('vendors.')->group(function () {
    Route::get('/', [VendorsController::class, 'index'])->name('index');
    Route::get('/{vendor}', [VendorsController::class, 'show'])->name('show');
});

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    // Search
    Route::get('/search', [EventsController::class, 'search'])->name('search');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Event registration (auth required)
    Route::post('/events/{event}/register', [EventsController::class, 'storeRegistration'])
        ->name('events.register');

    // Expedition applications (auth required)
    Route::prefix('expeditions')->name('expeditions.')->group(function () {
        Route::get('/{expedition}/apply', [ExpeditionsController::class, 'create'])->name('apply');
        Route::post('/{expedition}/apply', [ExpeditionsController::class, 'store'])->name('store');
    });

    // Profile management
    Route::prefix('profile')->name('profile.')->group(function () {
        // Profile editing
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');

        // Documents
        Route::get('/documents', [ProfileController::class, 'documents'])->name('documents');
        Route::post('/documents', [ProfileController::class, 'uploadDocument'])->name('documents.upload');
        Route::delete('/documents/{document}', [ProfileController::class, 'deleteDocument'])->name('documents.delete');

        // Medical information
        Route::get('/medical', [ProfileController::class, 'medical'])->name('medical');
        Route::post('/medical', [ProfileController::class, 'updateMedical'])->name('medical.update');

        // Membership
        Route::get('/membership', [ProfileController::class, 'membership'])->name('membership');

        // Badges
        Route::get('/badges', [ProfileController::class, 'badges'])->name('badges');
    });

    // Community posting (auth required)
    Route::prefix('community')->name('community.')->group(function () {
        Route::get('/create', [CommunityController::class, 'create'])->name('create');
        Route::post('/', [CommunityController::class, 'store'])->name('store');
    });
});

Route::middleware('auth')->group(function () {
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Members management
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/', [MembersController::class, 'index'])->name('index');
            Route::get('/{user}', [MembersController::class, 'show'])->name('show');
            Route::get('/{user}/edit', [MembersController::class, 'edit'])->name('edit');
            Route::patch('/{user}', [MembersController::class, 'update'])->name('update');
            Route::post('/{user}/verify', [MembersController::class, 'verify'])->name('verify');
            Route::post('/{user}/suspend', [MembersController::class, 'suspend'])->name('suspend');
            Route::post('/{user}/reactivate', [MembersController::class, 'reactivate'])->name('reactivate');
            Route::delete('/{user}', [MembersController::class, 'destroy'])->name('destroy');
        });

        // Document verification
        Route::prefix('documents')->name('documents.')->group(function () {
            Route::get('/', [DocumentsController::class, 'index'])->name('index');
            Route::get('/{document}', [DocumentsController::class, 'show'])->name('show');
            Route::post('/{document}/verify', [DocumentsController::class, 'verify'])->name('verify');
            Route::post('/{document}/reject', [DocumentsController::class, 'reject'])->name('reject');
            Route::post('/{document}/clear-rejection', [DocumentsController::class, 'clearRejection'])->name('clearRejection');
            Route::post('/bulk-verify', [DocumentsController::class, 'bulkVerify'])->name('bulkVerify');
        });

        // Events management
        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [AdminEventsController::class, 'index'])->name('index');
            Route::get('/create', [AdminEventsController::class, 'create'])->name('create');
            Route::post('/', [AdminEventsController::class, 'store'])->name('store');
            Route::get('/{event}', [AdminEventsController::class, 'show'])->name('show');
            Route::get('/{event}/edit', [AdminEventsController::class, 'edit'])->name('edit');
            Route::patch('/{event}', [AdminEventsController::class, 'update'])->name('update');
            Route::delete('/{event}', [AdminEventsController::class, 'destroy'])->name('destroy');
            Route::post('/{event}/publish', [AdminEventsController::class, 'publish'])->name('publish');
            Route::post('/{event}/cancel', [AdminEventsController::class, 'cancel'])->name('cancel');
            Route::post('/{event}/complete', [AdminEventsController::class, 'complete'])->name('complete');
        });

        // Expeditions management
        Route::prefix('expeditions')->name('expeditions.')->group(function () {
            Route::get('/', [AdminExpeditionsController::class, 'index'])->name('index');
            Route::get('/create', [AdminExpeditionsController::class, 'create'])->name('create');
            Route::post('/', [AdminExpeditionsController::class, 'store'])->name('store');
            Route::get('/{expedition}', [AdminExpeditionsController::class, 'show'])->name('show');
            Route::get('/{expedition}/edit', [AdminExpeditionsController::class, 'edit'])->name('edit');
            Route::patch('/{expedition}', [AdminExpeditionsController::class, 'update'])->name('update');
            Route::delete('/{expedition}', [AdminExpeditionsController::class, 'destroy'])->name('destroy');
            Route::post('/{expedition}/open', [AdminExpeditionsController::class, 'open'])->name('open');
            Route::post('/{expedition}/close', [AdminExpeditionsController::class, 'close'])->name('close');
            Route::post('/{expedition}/complete', [AdminExpeditionsController::class, 'complete'])->name('complete');
            Route::post('/{expedition}/cancel', [AdminExpeditionsController::class, 'cancel'])->name('cancel');
            Route::get('/{expedition}/applications', [AdminExpeditionsController::class, 'applications'])->name('applications');
            Route::post('/{application}/approve', [AdminExpeditionsController::class, 'approveApplication'])->name('approveApplication');
            Route::post('/{application}/reject', [AdminExpeditionsController::class, 'rejectApplication'])->name('rejectApplication');
        });

        // Community moderation
        Route::prefix('community')->name('community.')->group(function () {
            Route::get('/', [AdminCommunityController::class, 'index'])->name('index');
            Route::post('/{post}/approve', [AdminCommunityController::class, 'approve'])->name('approve');
            Route::post('/{post}/hide', [AdminCommunityController::class, 'hide'])->name('hide');
            Route::post('/{post}/unhide', [AdminCommunityController::class, 'unhide'])->name('unhide');
            Route::delete('/{post}', [AdminCommunityController::class, 'destroy'])->name('destroy');
        });

        // Vendors management
        Route::prefix('vendors')->name('vendors.')->group(function () {
            Route::get('/', [AdminVendorsController::class, 'index'])->name('index');
            Route::get('/create', [AdminVendorsController::class, 'create'])->name('create');
            Route::post('/', [AdminVendorsController::class, 'store'])->name('store');
            Route::get('/{vendor}', [AdminVendorsController::class, 'show'])->name('show');
            Route::get('/{vendor}/edit', [AdminVendorsController::class, 'edit'])->name('edit');
            Route::patch('/{vendor}', [AdminVendorsController::class, 'update'])->name('update');
            Route::delete('/{vendor}', [AdminVendorsController::class, 'destroy'])->name('destroy');
            Route::post('/{vendor}/verify', [AdminVendorsController::class, 'verify'])->name('verify');
            Route::post('/{vendor}/suspend', [AdminVendorsController::class, 'suspend'])->name('suspend');
            Route::post('/{vendor}/reactivate', [AdminVendorsController::class, 'reactivate'])->name('reactivate');
            Route::post('/{vendor}/rating', [AdminVendorsController::class, 'updateRating'])->name('updateRating');
        });

        // Badges management
        Route::prefix('badges')->name('badges.')->group(function () {
            Route::get('/', [BadgesController::class, 'index'])->name('index');
            Route::get('/create', [BadgesController::class, 'create'])->name('create');
            Route::post('/', [BadgesController::class, 'store'])->name('store');
            Route::get('/{badge}', [BadgesController::class, 'show'])->name('show');
            Route::get('/{badge}/edit', [BadgesController::class, 'edit'])->name('edit');
            Route::patch('/{badge}', [BadgesController::class, 'update'])->name('update');
            Route::delete('/{badge}', [BadgesController::class, 'destroy'])->name('destroy');
            Route::post('/award', [BadgesController::class, 'award'])->name('award');
        });
    });
});
