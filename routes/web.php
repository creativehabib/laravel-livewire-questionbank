<?php

use App\Livewire\QuestionCreate;
use App\Livewire\QuestionList;
use App\Livewire\QuestionShow;
use App\Livewire\QuestionEdit;
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
    Route::get('/questions/{question}/edit', QuestionEdit::class)->name('questions.edit');

    Route::view('/subjects/add', 'subjects.add')->name('subjects.add');
    Route::view('/subjects/edit', 'subjects.edit')->name('subjects.edit');
    Route::view('/subjects/delete', 'subjects.delete')->name('subjects.delete');

    Route::view('/chapters/add', 'chapters.add')->name('chapters.add');
    Route::view('/chapters/edit', 'chapters.edit')->name('chapters.edit');
    Route::view('/chapters/delete', 'chapters.delete')->name('chapters.delete');

    Route::view('/tags/add', 'tags.add')->name('tags.add');
    Route::view('/tags/edit', 'tags.edit')->name('tags.edit');
    Route::view('/tags/delete', 'tags.delete')->name('tags.delete');
});

require __DIR__.'/auth.php';
