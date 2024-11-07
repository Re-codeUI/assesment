<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'questions'], function(){
    Route::get('index', [App\Http\Controllers\Question\QuestionController::class, 'index'])->name('questions');
    Route::get('create', [App\Http\Controllers\Question\QuestionController::class, 'create'])->name('questions.create');
    Route::post('store', [App\Http\Controllers\Question\QuestionController::class, 'store'])->name('questions.store');
    Route::get('edit/{question}', [App\Http\Controllers\Question\QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('update/{question}', [App\Http\Controllers\Question\QuestionController::class, 'update'])->name('questions.update');

});
