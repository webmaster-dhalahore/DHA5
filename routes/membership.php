<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Membership\MemberCategoryController;
use App\Http\Controllers\Membership\MemberAccountController;
use App\Http\Controllers\Membership\MemberController;
use App\Http\Controllers\Membership\MemberFamilyController;
use App\Http\Controllers\Membership\MemberReportsController;
use App\Http\Controllers\Membership\MemberTypeController;


Route::group(['prefix' => 'members', 'as' => 'member.', 'middleware' => 'auth'], function () {
    // Member Advanced Search Routes
    Route::get('/search', [MemberController::class, 'search'])->name('search');
    Route::post('/search', [MemberController::class, 'submitSearch'])->name('submitSearch');
    // Route::post('/member-search', [MemberController::class, 'memberSearch'])->name('member-search');

    Route::get('/', [MemberController::class, 'index'])->name('index');
    Route::get('/getMembers', [MemberController::class, 'getMembers'])->name('getMembers');

    Route::post('/', [MemberController::class, 'store'])->name('store');
    Route::get('/create', [MemberController::class, 'create'])->name('create');
    Route::get('/update-status', [MemberController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/update-status', [MemberController::class, 'updateStatus']);

    Route::get('/home', [MemberController::class, 'home'])->name('home');
    // Route::get('/{memberid}', [MemberController::class, 'show'])->name('show');

    Route::get('/{memberid}/edit', [MemberController::class, 'edit'])->name('edit');
    Route::patch('/{membersr}', [MemberController::class, 'update'])->name('update');

    Route::get('/reports/age-wise', [MemberReportsController::class, 'ageWise'])->name('reports.ageWise');
    Route::post('/reports/age-wise', [MemberReportsController::class, 'ageWise'])->name('reports.ageWisePost');

    Route::get('/reports/dependents', [MemberReportsController::class, 'memberDependents'])->name('reports.dependents');
    Route::post('/reports/dependents', [MemberReportsController::class, 'memberDependents'])->name('reports.dependentsPost');

    Route::get('/reports/summary', [MemberReportsController::class, 'memberSummary'])->name('reports.summary');
    Route::post('/reports/summary', [MemberReportsController::class, 'memberSummary'])->name('reports.summaryPost');
    Route::get('/reports/summary/{categoryid}', [MemberReportsController::class, 'memberSummaryType'])->name('reports.memberSummaryType');

    Route::get('/reports/member-info', [MemberReportsController::class, 'memberInfo'])->name('reports.member-info');
    Route::post('/reports/member-info', [MemberReportsController::class, 'memberInfo'])->name('reports.member-infoPost');

    Route::get('/reports/member-profile', [MemberReportsController::class, 'memberProfile'])->name('reports.member-profile');
    Route::post('/reports/member-profile', [MemberReportsController::class, 'memberProfile'])->name('reports.member-profilePost');

    Route::get('/reports/ledger', [MemberAccountController::class, 'memberLedger'])->name('reports.member-ledger');
    Route::post('/reports/ledger', [MemberAccountController::class, 'memberLedger'])->name('reports.member-ledgerPost');
    Route::post('/reports/ledger-download-pdf', [MemberAccountController::class, 'memberLedgerDownloadPDF'])->name('reports.member-ledger-download');

    Route::post('/family', [MemberFamilyController::class, 'store'])->name('family.store');
    Route::patch('/family', [MemberFamilyController::class, 'update'])->name('family.update');


    Route::get('/categories', [MemberCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [MemberCategoryController::class, 'store'])->name('categories.store');
    Route::post('/categories/edit', [MemberCategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/delete', [MemberCategoryController::class, 'destroy'])->name('categories.destroy');


    Route::get('/types', [MemberTypeController::class, 'index'])->name('types.index');
    Route::post('/types', [MemberTypeController::class, 'store'])->name('types.store');
    Route::post('/types/edit', [MemberTypeController::class, 'update'])->name('types.update');
    Route::post('/types/delete', [MemberTypeController::class, 'destroy'])->name('types.destroy');
});
