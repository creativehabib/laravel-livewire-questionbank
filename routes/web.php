<?php

use App\Livewire\QuestionCreate;
use App\Livewire\QuestionList;
use App\Livewire\QuestionShow;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/questions', QuestionList::class)->name('questions');
    Route::get('/questions/create', QuestionCreate::class)->name('questions.create');
    Route::get('/questions/{question}', QuestionShow::class)->name('questions.show');
    Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
});

require __DIR__.'/auth.php';
