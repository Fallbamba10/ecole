<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

// Language switcher
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Inscription école (self-service)
Route::get('/register/school', [App\Http\Controllers\SchoolRegistrationController::class, 'create'])->name('register.school');
Route::post('/register/school', [App\Http\Controllers\SchoolRegistrationController::class, 'store'])->name('register.school.store');

// Pages légales
Route::get('/cgu', fn() => view('pages.cgu'))->name('pages.cgu');
Route::get('/confidentialite', fn() => view('pages.privacy'))->name('pages.privacy');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'subscription'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('classrooms', ClassroomController::class);

    // Import CSV (doit être avant la resource students pour éviter conflit avec {student})
    Route::get('/students/import', [App\Http\Controllers\StudentImportController::class, 'show'])->name('students.import');
    Route::post('/students/import', [App\Http\Controllers\StudentImportController::class, 'import'])->name('students.import.store');

    Route::resource('students', StudentController::class);
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/receipt', [PaymentController::class, 'receipt'])->name('payments.receipt');
    Route::resource('grades', GradeController::class);
    Route::get('/grades-batch', [GradeController::class, 'batch'])->name('grades.batch');
    Route::post('/grades-batch', [GradeController::class, 'batchStore'])->name('grades.batch.store');
    Route::resource('subjects', SubjectController::class)->only(['index', 'store', 'destroy']);

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/history/{student}', [AttendanceController::class, 'history'])->name('attendances.history');

    Route::resource('announcements', AnnouncementController::class)->only(['index', 'create', 'store', 'destroy']);

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

    Route::get('/bulletins/{student}', [BulletinController::class, 'show'])->name('bulletins.show');
    Route::get('/bulletins/{student}/pdf', [BulletinController::class, 'pdf'])->name('bulletins.pdf');

    // Emploi du temps
    Route::get('/timetable', [App\Http\Controllers\TimetableController::class, 'index'])->name('timetable.index');
    Route::get('/timetable/create', [App\Http\Controllers\TimetableController::class, 'create'])->name('timetable.create');
    Route::post('/timetable', [App\Http\Controllers\TimetableController::class, 'store'])->name('timetable.store');
    Route::delete('/timetable/{timetableSlot}', [App\Http\Controllers\TimetableController::class, 'destroy'])->name('timetable.destroy');

    // Paramètres école
    Route::get('/settings', [App\Http\Controllers\SchoolSettingsController::class, 'edit'])->name('school.settings');
    Route::put('/settings', [App\Http\Controllers\SchoolSettingsController::class, 'update'])->name('school.settings.update');

    // Exports
    Route::get('/export/payments', [App\Http\Controllers\ExportController::class, 'paymentsExport'])->name('export.payments');
    Route::get('/export/attendances', [App\Http\Controllers\ExportController::class, 'attendancesExport'])->name('export.attendances');
    Route::get('/export/grades', [App\Http\Controllers\ExportController::class, 'gradesExport'])->name('export.grades');
    Route::get('/export/students', [App\Http\Controllers\ExportController::class, 'studentsExport'])->name('export.students');

    // Enseignants
    Route::resource('teachers', App\Http\Controllers\TeacherController::class);

    // Années scolaires
    Route::get('/school-years', [App\Http\Controllers\SchoolYearController::class, 'index'])->name('school-years.index');
    Route::post('/school-years', [App\Http\Controllers\SchoolYearController::class, 'store'])->name('school-years.store');
    Route::patch('/school-years/{schoolYear}/activate', [App\Http\Controllers\SchoolYearController::class, 'activate'])->name('school-years.activate');
    Route::get('/school-years/promote', [App\Http\Controllers\SchoolYearController::class, 'promoteForm'])->name('school-years.promote-form');
    Route::post('/school-years/promote', [App\Http\Controllers\SchoolYearController::class, 'promote'])->name('school-years.promote');

    // Structure des frais
    Route::get('/fees', [App\Http\Controllers\FeeStructureController::class, 'index'])->name('fees.index');
    Route::post('/fees', [App\Http\Controllers\FeeStructureController::class, 'store'])->name('fees.store');
    Route::delete('/fees/{fee}', [App\Http\Controllers\FeeStructureController::class, 'destroy'])->name('fees.destroy');

    // Documents PDF (attestation, certificat de scolarité)
    Route::get('/students/{student}/attestation', [App\Http\Controllers\DocumentController::class, 'attestation'])->name('documents.attestation');
    Route::get('/students/{student}/scolarite', [App\Http\Controllers\DocumentController::class, 'scolarite'])->name('documents.scolarite');

    // SMS parents
    Route::get('/sms', [App\Http\Controllers\SmsController::class, 'index'])->name('sms.index');
    Route::post('/sms', [App\Http\Controllers\SmsController::class, 'send'])->name('sms.send');

    // Messagerie interne
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::resource('messages', MessageController::class)->except(['edit', 'update']);

    // Statistiques
    Route::get('/statistics', [App\Http\Controllers\StatisticsController::class, 'index'])->name('statistics.index');

    // Recherche globale
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'search'])->name('search');
});

// Super Admin routes
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('schools', App\Http\Controllers\SuperAdmin\SchoolController::class);
});

// Portail parents
Route::middleware(['auth'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/', [App\Http\Controllers\ParentPortalController::class, 'index'])->name('index');
    Route::get('/grades/{student}', [App\Http\Controllers\ParentPortalController::class, 'grades'])->name('grades');
    Route::get('/attendances/{student}', [App\Http\Controllers\ParentPortalController::class, 'attendances'])->name('attendances');
    Route::get('/payments/{student}', [App\Http\Controllers\ParentPortalController::class, 'payments'])->name('payments');
    Route::get('/bulletin/{student}', [App\Http\Controllers\ParentPortalController::class, 'bulletin'])->name('bulletin');
});

// Abonnement
Route::middleware(['auth'])->group(function () {
    Route::get('/subscription', [App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscription.index');
    Route::post('/subscription/change-plan', [App\Http\Controllers\SubscriptionController::class, 'changePlan'])->name('subscription.changePlan');
    Route::get('/subscription/billing', [App\Http\Controllers\SubscriptionController::class, 'billingHistory'])->name('subscription.billing');
});

// Page abonnement expiré
Route::get('/subscription/expired', function () {
    return view('subscription.expired');
})->middleware('auth')->name('subscription.expired');

require __DIR__.'/auth.php';
