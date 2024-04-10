<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WorkspaceController;


Route::group(['middleware' => 'guest'], function () {

    Route::get('/register', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'signin'])->name('signin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
});



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [MainController::class, 'index'])->name('home.index');
    // Route::get('/home', [MainController::class, 'index'])->name('home.index');

    Route::get('/workspace/create', [WorkspaceController::class, 'create'])->name('workspace.create');
    Route::post('/workspace/create', [WorkspaceController::class, 'store'])->name('workspace.store');

    Route::get('/workspace/{workspace}', [WorkspaceController::class, 'index'])->name('workspace.index');
    Route::get('/workspace/{workspace}/collection', [WorkspaceController::class, 'collections'])->name('workspace.collections');
    Route::get('/workspace/{workspace}/collection/edit_{collection}', [WorkspaceController::class, 'editCollection'])->name('workspace.editCollection');
    Route::get('/workspace/{workspace}/history', [WorkspaceController::class, 'history'])->name('workspace.history');
    Route::get('/delete-collections-tabs/{collection}', [WorkspaceController::class, 'deleteFromCollectionTabs'])->name('delete.collection.tabs');
    Route::post('/workspace/{workspace}/collection/importfile/{collection}',[WorkspaceController::class,'import_file'])->name('importFile');

    Route::get('/workspace/{workspace}/setting', [WorkspaceController::class, 'setting'])->name('workspace.setting');
    Route::post('/workspace/{workspace}/setting-access', [WorkspaceController::class, 'setting_access'])->name('access.setting');
    Route::get('/workspace/{workspace}/delete-collection', [WorkspaceController::class, 'deleteCollection'])->name('workspace.deleteCollection');
   
    Route::get('/workspace/{workspace}/trash', [WorkspaceController::class, 'trash'])->name('workspace.trash');
    Route::get('/delete-collection/{collection}', [WorkspaceController::class, 'delete_collection'])->name('delete.collection');
    Route::get('/delete-collection-form-trash/{collection}', [WorkspaceController::class, 'delete'])->name('deletedreal.collection');
    Route::get('/recover-collection/{collection}', [WorkspaceController::class, 'recover_collection'])->name('recover.collection');


    Route::get('/delete-workspace/{workspace}', [WorkspaceController::class, 'delete_workspace'])->name('workspace.deleteWorkspace');
    Route::get('/all-workspace', [WorkspaceController::class, 'view_allworkspace'])->name('workspace.all_workspace');
    Route::post('/export', [WorkspaceController::class, 'wordExport'])->name('home.exportfile');

    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/team', function () {
    return view('team_submit');
});