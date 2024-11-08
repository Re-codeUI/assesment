<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'users'], function(){
    Route::get('index', [App\Http\Controllers\User\UserController::class, 'index'])->name('users');
    Route::get('create', [App\Http\Controllers\User\UserController::class, 'create'])->name('users.create');
    Route::post('store', [App\Http\Controllers\User\UserController::class, 'store'])->name('users.store');
    Route::get('show/{user}', [App\Http\Controllers\User\UserController::class, 'show'])->name('users.show');
    Route::get('edit/{user}', [App\Http\Controllers\User\UserController::class, 'edit'])->name('users.edit');
    Route::put('update/{user}', [App\Http\Controllers\User\UserController::class, 'update'])->name('users.update');
    Route::delete('destroy/{user}', [App\Http\Controllers\User\UserController::class, 'destroy'])->name('users.destroy');
});

Route::group(['prefix' => 'roles'], function(){
    Route::get('index', [App\Http\Controllers\Role\RoleController::class, 'index'])->name('roles');
    Route::get('create', [App\Http\Controllers\Role\RoleController::class, 'create'])->name('roles.create');
    Route::post('store', [App\Http\Controllers\Role\RoleController::class, 'store'])->name('roles.store');
    Route::get('show/{role}', [App\Http\Controllers\Role\RoleController::class, 'show'])->name('roles.show');
    Route::get('edit/{role}', [App\Http\Controllers\Role\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('update/{role}', [App\Http\Controllers\Role\RoleController::class, 'update'])->name('roles.update');
    Route::delete('destroy/{role}', [App\Http\Controllers\Role\RoleController::class, 'destroy'])->name('roles.destroy');
});

Route::group(['prefix' => 'questions'], function(){
    Route::get('index', [App\Http\Controllers\Question\QuestionController::class, 'index'])->name('questions');
    Route::get('create', [App\Http\Controllers\Question\QuestionController::class, 'create'])->name('questions.create');
    Route::post('store', [App\Http\Controllers\Question\QuestionController::class, 'store'])->name('questions.store');
    Route::get('edit/{question}', [App\Http\Controllers\Question\QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('update/{question}', [App\Http\Controllers\Question\QuestionController::class, 'update'])->name('questions.update');

});
