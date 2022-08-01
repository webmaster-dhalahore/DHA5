<?php

use App\Http\Controllers\Billings\PastryShop\PastryShopBillingController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\Membership\MemberController;
use App\Http\Controllers\Membership\MemberFamilyController;
use App\Http\Controllers\Membership\MemberOccupationController;
use App\Http\Controllers\Membership\MemberReportsController;
use App\Http\Controllers\Membership\MemberTypeController;
use App\Http\Controllers\UserManagement\UserRolesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/api/v1', 'as' => 'apis.', 'middleware' => 'auth'], function () {
    Route::get('/clubs', [ClubController::class, 'getAllClubs'])->name('getClubs');
    Route::get('/professions', [MemberOccupationController::class, 'professions_all'])->name('getProfessions');
    Route::get('/memberTypes', [MemberTypeController::class, 'membertypes_all'])->name('getMemberTypes');
    Route::get('/summary', [MemberReportsController::class, 'summaryAPI'])->name('getMemberSummary');
    Route::post('/getMember', [MemberController::class, 'getMember'])->name('getMember');
    Route::get('/getMemberBySR', [MemberController::class, 'getMemberBySR'])->name('getMemberBySR');
    Route::get('/getMemberByID', [MemberController::class, 'getMemberByID'])->name('getMemberByID');
    Route::post('/member-family-all', [MemberFamilyController::class, 'getMemberFamilyAll'])->name('getMemberFamilyAll');
    Route::get('/familyByVNO/{vno}', [MemberFamilyController::class, 'familyByVNO'])->name('getFamilyByVNO');

    Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
        Route::get('/permissions-all', [UserRolesController::class, 'permissionAll'])->name('permissionAll');
    });

    Route::get('/members', [MemberController::class, 'membersForLov'])->name('members_lov');
    Route::get('/ps-items', [PastryShopBillingController::class, 'psItems'])->name('ps_items');
});
