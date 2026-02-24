<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\CaseController;

// -------------------- Admin imports --------------------
Route::post('/admin/import', [AdminController::class, 'import'])->name('admin.import');
Route::get('/admin/data', [AdminController::class, 'getData'])->name('admin.data');

// -------------------- Login page --------------------
Route::get('/iworks_peopleworks', fn() => view('login'));

// -------------------- User registration --------------------
Route::get('/register', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::patch('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// -------------------- Authentication --------------------
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'attemptLogin'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// -------------------- Admin pages --------------------
Route::get('/iworks_peopleworks/overall', fn() => view('adminMasterfile'));
Route::get('/iworks_peopleworks/import', fn() => view('importAdmin'));

// -------------------- Case Management (Admin only) --------------------
Route::get('/admin/case-management', [CaseController::class, 'index'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('case.management');

// -------------------- Case Management JSON API --------------------
Route::get('/cases/json', [CaseController::class, 'getCasesJson'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.json');

// -------------------- Add Case (Admin only) --------------------
Route::post('/cases', [CaseController::class, 'store'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.store');

// -------------------- Case Details (Admin only) --------------------
// JSON detail for AJAX
Route::get('/cases/{id}/json', [CaseController::class, 'show'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.show');

// Read-only detail page
Route::get('/cases/{id}/details', [CaseController::class, 'showDetails'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.showDetails');

// Editable detail page
Route::get('/cases/{id}/edit', [CaseController::class, 'edit'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.edit');

// Update case
Route::patch('/cases/{id}', [CaseController::class, 'update'])
    ->middleware(['auth.session', 'userlevel:Admin'])
    ->name('cases.update');

// -------------------- Leave Application (CE) --------------------
Route::get('/leave/apply', fn() => view('leaveApply'))
    ->middleware(['auth.session', 'userlevel:CE'])->name('leave.apply');
Route::post('/leave/submit', [LeaveController::class, 'submit'])->name('leave.submit');

// -------------------- Leave Applications Review (Admin) --------------------
Route::get('/admin/leave-review', [LeaveController::class, 'review'])
    ->middleware(['auth.session', 'userlevel:Admin'])->name('leave.review');
Route::post('/admin/leave/{id}/accept', [LeaveController::class, 'accept'])
    ->middleware(['auth.session', 'userlevel:Admin'])->name('leave.accept');
Route::post('/admin/leave/{id}/decline', [LeaveController::class, 'decline'])
    ->middleware(['auth.session', 'userlevel:Admin'])->name('leave.decline');

// -------------------- Dashboards --------------------
Route::get('/engineer', fn() => view('MainPageEngineer'))
    ->middleware(['auth.session', 'userlevel:CE', 'track.active']);

Route::get('/admin', function () {
    $activeUsers = Cache::get('active_users_list', []);
    $activeUsers = array_filter($activeUsers, fn($data) => $data['expiry']->isFuture());
    $count = count($activeUsers);
    $roleCounts = [];
    foreach ($activeUsers as $data) {
        $roleCounts[$data['role']] = ($roleCounts[$data['role']] ?? 0) + 1;
    }
    return view('MainPageAdmin', [
        'activeUsers' => $count,
        'roleCounts'  => $roleCounts,
    ]);
})->middleware(['auth.session', 'userlevel:Admin', 'track.active']);

Route::get('/manager', fn() => view('MainPageManager'))
    ->middleware(['auth.session', 'userlevel:Manager', 'track.active']);
Route::get('/account', fn() => view('MainPageAccount'))
    ->middleware(['auth.session', 'userlevel:Account', 'track.active']);
Route::get('/guest', fn() => view('MainPageGuest'))
    ->middleware(['auth.session', 'userlevel:Guest', 'track.active']);

// -------------------- Report page --------------------
Route::get('/report', [ReportController::class, 'create'])->name('report.create');

// -------------------- Case report API --------------------
Route::get('/case-report/{caseId}', [AdminController::class, 'getCase'])->name('case.report');
