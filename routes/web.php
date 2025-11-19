<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FoodRequestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Role-specific login endpoints
Route::get('/login/{role}', [AuthController::class, 'showLogin'])->name('login.role');
Route::post('/login/{role}', [AuthController::class, 'loginForRole'])->name('login.role.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Fallback 404
Route::fallback(function () {
    abort(404);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    Route::get('/api/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('/api/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.markRead');
    Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // User feedback submission
    Route::post('/feedback/submit', [FeedbackController::class, 'store'])->name('feedback.submit');
});

// Donor routes (protected by donor role)
Route::middleware(['auth', 'role:donor'])->group(function () {
    Route::get('/donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
    Route::get('/donations/{donation}/matches', [DonationController::class, 'showMatches'])->name('donations.matches');
    Route::post('/donations/{donation}/match/{requestModel}', [DonationController::class, 'matchWithRequest'])->name('donations.match.withRequest');
});

// Beneficiary routes (protected by beneficiary role)
Route::middleware(['auth', 'role:beneficiary'])->group(function () {
    Route::get('/requests', [FoodRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [FoodRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [FoodRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{requestModel}/edit', [FoodRequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{requestModel}', [FoodRequestController::class, 'update'])->name('requests.update');
    Route::delete('/requests/{requestModel}', [FoodRequestController::class, 'destroy'])->name('requests.destroy');
    Route::get('/requests/{requestModel}/matches', [FoodRequestController::class, 'showMatches'])->name('requests.matches');
    Route::post('/requests/{requestModel}/match/{donation}', [FoodRequestController::class, 'matchWithDonation'])->name('requests.match.withDonation');
});

// Admin pages (protected by admin role)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/create', [AdminController::class, 'usersCreate'])->name('admin.users.create');
    Route::post('/admin/users', [AdminController::class, 'usersStore'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'usersEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'usersUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'usersDestroy'])->name('admin.users.destroy');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');

    // Enhanced Reports System
    Route::get('/admin/reports', [\App\Http\Controllers\Admin\ReportAdminController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/analytics', [\App\Http\Controllers\Admin\ReportAdminController::class, 'analytics'])->name('admin.reports.analytics');
    Route::get('/admin/reports/create', [\App\Http\Controllers\Admin\ReportAdminController::class, 'create'])->name('admin.reports.create');
    Route::post('/admin/reports', [\App\Http\Controllers\Admin\ReportAdminController::class, 'store'])->name('admin.reports.store');
    Route::get('/admin/reports/{report}', [\App\Http\Controllers\Admin\ReportAdminController::class, 'show'])->name('admin.reports.show');
    Route::delete('/admin/reports/{report}', [\App\Http\Controllers\Admin\ReportAdminController::class, 'destroy'])->name('admin.reports.destroy');
    Route::post('/admin/reports/generate/daily', [\App\Http\Controllers\Admin\ReportAdminController::class, 'generateDaily'])->name('admin.reports.generate.daily');
    Route::post('/admin/reports/generate/weekly', [\App\Http\Controllers\Admin\ReportAdminController::class, 'generateWeekly'])->name('admin.reports.generate.weekly');
    Route::post('/admin/reports/generate/monthly', [\App\Http\Controllers\Admin\ReportAdminController::class, 'generateMonthly'])->name('admin.reports.generate.monthly');
    Route::get('/admin/reports/export/pdf', [\App\Http\Controllers\Admin\ReportAdminController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/admin/reports/export/excel', [\App\Http\Controllers\Admin\ReportAdminController::class, 'exportExcel'])->name('admin.reports.export.excel');

    Route::get('/admin/feedback', [AdminController::class, 'feedbackIndex'])->name('admin.feedback');
    Route::post('/admin/feedback', [AdminController::class, 'feedbackStore'])->name('admin.feedback.store');
    Route::post('/admin/promote', [AdminController::class, 'promoteUser'])->name('admin.promote');

    // Admin Donations (no create)
    Route::get('/admin/donations', [\App\Http\Controllers\Admin\DonationAdminController::class, 'index'])->name('admin.donations.index');
    Route::get('/admin/donations/{donation}/edit', [\App\Http\Controllers\Admin\DonationAdminController::class, 'edit'])->name('admin.donations.edit');
    Route::put('/admin/donations/{donation}', [\App\Http\Controllers\Admin\DonationAdminController::class, 'update'])->name('admin.donations.update');
    Route::delete('/admin/donations/{donation}', [\App\Http\Controllers\Admin\DonationAdminController::class, 'destroy'])->name('admin.donations.destroy');

    // Admin Requests (no create)
    Route::get('/admin/requests', [\App\Http\Controllers\Admin\RequestAdminController::class, 'index'])->name('admin.requests.index');
    Route::get('/admin/requests/{requestModel}/edit', [\App\Http\Controllers\Admin\RequestAdminController::class, 'edit'])->name('admin.requests.edit');
    Route::put('/admin/requests/{requestModel}', [\App\Http\Controllers\Admin\RequestAdminController::class, 'update'])->name('admin.requests.update');
    Route::delete('/admin/requests/{requestModel}', [\App\Http\Controllers\Admin\RequestAdminController::class, 'destroy'])->name('admin.requests.destroy');

    // Admin Deliveries (full CRUD)
    Route::get('/admin/deliveries', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'index'])->name('admin.deliveries.index');
    Route::get('/admin/deliveries/create', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'create'])->name('admin.deliveries.create');
    Route::post('/admin/deliveries', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'store'])->name('admin.deliveries.store');
    Route::get('/admin/deliveries/{task}/edit', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'edit'])->name('admin.deliveries.edit');
    Route::put('/admin/deliveries/{task}', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'update'])->name('admin.deliveries.update');
    Route::delete('/admin/deliveries/{task}', [\App\Http\Controllers\Admin\DeliveryTaskAdminController::class, 'destroy'])->name('admin.deliveries.destroy');
});

// Volunteer pages (protected by volunteer role)
Route::middleware(['auth', 'role:volunteer'])->group(function () {
    Route::get('/volunteer/available', [VolunteerController::class, 'available'])->name('volunteer.available');
    Route::get('/volunteer/tasks', [VolunteerController::class, 'myTasks'])->name('volunteer.tasks');
    Route::post('/volunteer/tasks/{task}/start', [VolunteerController::class, 'start'])->name('volunteer.tasks.start');
    Route::post('/volunteer/tasks/{task}/claim', [VolunteerController::class, 'claim'])->name('volunteer.tasks.claim');
    Route::post('/volunteer/tasks/{task}/complete', [VolunteerController::class, 'complete'])->name('volunteer.tasks.complete');
});
