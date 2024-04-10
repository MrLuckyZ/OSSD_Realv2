<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\ForgetPasswordController;


Route::group(['middleware' => 'guest'], function () {

    Route::get('/register', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    Route::get('/login', [AuthController::class, 'signin'])->name('signin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('forgot');
});

//Route For Reset Password
Route::get('/reset-password/{token}',[ForgetPasswordController::class,'ResetPassword'])
->name('reset.password');
Route::get('/forget-password',[ForgetPasswordController::class,'ForgetPassword'])
->name('ForgetPassword');
Route::post('/forget-password',[ForgetPasswordController::class,'ForgetPasswordPost'])
->name('ForgetPassword.post');
Route::post("/reset-password",[ForgetPasswordController::class,'resetPasswordPost'])
->name('reset.password.post');



Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [MainController::class, 'index'])->name('home.index');
    // Route::get('/home', [MainController::class, 'index'])->name('home.index');

    Route::get('/workspace/create', [WorkspaceController::class, 'create'])->name('workspace.create');
    Route::post('/workspace/create', [WorkspaceController::class, 'store'])->name('workspace.store');

    Route::get('/workspace/{workspace}', [WorkspaceController::class, 'index'])->name('workspace.index');
    Route::get('/workspace/{workspace}/collection', [WorkspaceController::class, 'collections'])->name('workspace.collections');
    Route::get('/workspace/{workspace}/collection/edit_{collection}', [WorkspaceController::class, 'editCollection'])->name('workspace.editCollection');
    Route::get('/workspace/{workspace}/history', [WorkspaceController::class, 'history'])->name('workspace.history');
    Route::get('/workspace/{workspace}/trash', [WorkspaceController::class, 'trash'])->name('workspace.trash');
    Route::get('/delete-collections-tabs/{collection}', [WorkspaceController::class, 'deleteFromCollectionTabs'])->name('delete.collection.tabs');

    Route::get('/workspace/{workspace}/setting', [WorkspaceController::class, 'setting'])->name('workspace.setting');
    Route::post('/workspace/{workspace}/setting-access', [WorkspaceController::class, 'setting_access'])->name('access.setting');
    Route::get('/workspace/{workspace}/delete-collection', [WorkspaceController::class, 'deleteCollection'])->name('workspace.deleteCollection');

    Route::get('/delete-workspace/{workspace}', [WorkspaceController::class, 'delete_workspace'])->name('workspace.deleteWorkspace');
    Route::get('/all-workspace', [WorkspaceController::class, 'view_allworkspace'])->name('workspace.all_workspace');
    Route::post('/export', [WorkspaceController::class, 'wordExport'])->name('home.exportfile');

    Route::post('/workspace/{workspace}/collection/importfile/{collection}',[WorkspaceController::class,'import_file'])->name('importFile');
    Route::post('/workspace/{workspace}/collection/save',[WorkspaceController::class,'save_json_data'])->name('workspace.toWorkspace');
    Route::post('/workspace/{workspace}/collection/save-as-json',[WorkspaceController::class,'save_as_json'])->name('workspace.toJson');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/team', function () {
    return view('team_submit');
});