<?php

use App\Http\Controllers\HappeningController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/invitation', [InvitationController::class, 'createFromUser']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [UserController::class, 'show']);
    Route::get('/users/{name}', [UserController::class, 'getUserByNameOrEmail']);
    // Teams
    Route::post('/team', [TeamController::class, 'create']);
    Route::get('/teams/{name}', [TeamController::class, 'getTeamsByName']);
    // invitations
    Route::post('/user/invitation', [InvitationController::class, 'createFromUser']);
    Route::put('user/invitation/{id}', [InvitationController::class, 'manageTeamInvitation']);
});

Route::middleware(['auth:sanctum', 'isTeamMember'])->group(function () {
    Route::get('/team/{id}', [TeamController::class, 'show']);
    Route::delete('/team/{id}/leave', [TeamController::class, 'leaveTeam']);
});

Route::middleware(['auth:sanctum', 'isTeamAdmin'])->group(function () {
    Route::delete('/team/{id}', [TeamController::class, 'delete']);
    Route::put('/team/{id}/admin', [TeamController::class, 'manageAdmin']);
    Route::delete('/team/{id}/member/{memberId}', [TeamController::class, 'removeMember']);
    Route::post('/team/{id}/invitation', [InvitationController::class, 'createFromTeam']);
    Route::put('/team/{id}/invitation/{invitationId}', [InvitationController::class, 'manageUserInvitation']);
    Route::post('/team/{id}/happening', [HappeningController::class, 'create']);
});

Route::middleware(['auth:sanctum', 'isHappeningMember'])->group(function () {
    Route::get('/happening/{id}', [HappeningController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'isHappeningAdmin'])->group(function () {
    Route::put('/happening/{id}', [HappeningController::class, 'update']);
    Route::delete('/happening/{id}', [HappeningController::class, 'delete']);
});
