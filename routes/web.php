<?php

use App\Livewire\ExamPage;
use App\Livewire\MockTestSetup;
use App\Livewire\Qbank\ChapterManager;
use App\Livewire\Qbank\SubjectManager;
use App\Livewire\Qbank\TagManager;
use App\Livewire\QuestionCreate;
use App\Livewire\QuestionEdit;
use App\Livewire\QuestionForm;
use App\Livewire\QuestionList;
use App\Livewire\QuestionShow;
use App\Livewire\Admin\MessageRetentionSettings;
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
//    Route::get('/questions', QuestionList::class)->name('questions.index');
//    Route::get('/questions/create', QuestionCreate::class)->name('questions.create');
//    Route::get('/questions/{question}', QuestionShow::class)->name('questions.show');
//    Route::get('/questions/{question}/edit', QuestionEdit::class)->name('questions.edit');

    Route::get('/questions', QuestionList::class)->name('questions.index');
    Route::get('/questions/create', QuestionForm::class)->name('questions.create');
    Route::get('/questions/{question}/edit', QuestionForm::class)->name('questions.edit');



    Route::get('/subjects', SubjectManager::class)->name('subjects.index');
    Route::get('/chapters', ChapterManager::class)->name('chapters.index');
    Route::get('/tags', TagManager::class)->name('tags.index');
    Route::get('/message-settings', MessageRetentionSettings::class)->name('admin.message-settings');
});

Route::get('/mock-test', MockTestSetup::class)->name('mock.test')->middleware('auth');
Route::get('/exam', ExamPage::class)->name('exam.start')->middleware('auth');
require __DIR__.'/auth.php';
