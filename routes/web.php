<?php

declare(strict_types=1);

use \Francken\Association\Members\Http\ExpensesController;
use \Francken\Association\Members\Http\ProfileController;
use Francken\Association\News\Http\NewsController;
use Francken\Association\Symposium\Http\ParticipantRegistrationController;
use Francken\Auth\Http\Controllers\ForgotPasswordController;
use Francken\Auth\Http\Controllers\LoginController;
use Francken\Auth\Http\Controllers\ResetPasswordController;
use Francken\Infrastructure\Http\Controllers\BookController;
use Francken\Infrastructure\Http\Controllers\CareerController;
use Francken\Infrastructure\Http\Controllers\CommitteesController;
use Francken\Infrastructure\Http\Controllers\CompaniesController;
use Francken\Infrastructure\Http\Controllers\MainContentController;
use Francken\Infrastructure\Http\Controllers\RegistrationController;
use Francken\Infrastructure\Http\Controllers\ResearchGroupsController;
use Francken\Shared\Http\Controllers\RedirectController;

Route::redirect('/blog', '/association/news');
Route::permanentRedirect('/wordpress', '/');
Route::redirect('/books', '/study/books');
Route::redirect('/boeken', '/study/books');
Route::redirect('/photos', '/association/photos');
Route::get('/wordpress/{url}', [RedirectController::class, 'wordpress'])->where('url', '.*');
Route::get('/scriptcie/{url}', [RedirectController::class, 'scriptcie'])->where('url', '.*');

Route::get('/', [MainContentController::class, 'index'])->name('home');

Route::get('/register', [RegistrationController::class, 'request']);
Route::post('/register', [RegistrationController::class, 'submitRequest']);
Route::get('/register/success', [RegistrationController::class, 'success']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['prefix' => 'study'], function () : void {
    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{book}', [BookController::class, 'show']);
    Route::put('books/{bookId}/buy', [BookController::class, 'buy'])->middleware('auth');

    Route::get('research-groups', [ResearchGroupsController::class, 'index']);
    Route::get('research-groups/{group}', [ResearchGroupsController::class, 'show']);
});

Route::group(['prefix' => 'association'], function () : void {
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/archive', [NewsController::class, 'archive']);
    Route::get('/news/{item}', [NewsController::class, 'show']);

    Route::get('activities', [\Francken\Association\Activities\Http\ActivitiesController::class, 'index']);
    Route::get('activities/ical', [\Francken\Association\Activities\Http\IcalController::class, 'index']);
    Route::get('activities/ical/all', [\Francken\Association\Activities\Http\IcalController::class, 'show']);
    Route::get('activities/{year}/{month}', [\Francken\Association\Activities\Http\ActivitiesPerMonthController::class, 'index']);

    Route::get('committees', [CommitteesController::class, 'index']);
    Route::get('committees/{committee}', [CommitteesController::class, 'show']);

    Route::get('boards', [\Francken\Association\Boards\Http\Controllers\BoardsController::class, 'index']);
    Route::get('boards/birthdays', [\Francken\Association\Boards\Http\Controllers\BirthdaysController::class, 'index'])
        ->middleware(['role:Board|Old Board']);

    Route::get('photos/login', [\Francken\Association\Photos\Http\Controllers\AuthenticationController::class, 'index']);
    Route::post('photos', [\Francken\Association\Photos\Http\Controllers\AuthenticationController::class, 'store']);
    Route::group(['middleware' => ['login-to-view-photos']], function () : void {
        Route::get('photos', [\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'index']);
        Route::get('photos/{album}', [\Francken\Association\Photos\Http\Controllers\PhotosController::class, 'show']);
    });
});

Route::group(['prefix' => 'career'], function () : void {
    Route::get('/', [CareerController::class, 'index']);
    Route::get('job-openings', [CareerController::class, 'jobs'])->name('job-openings');
    Route::get('companies', [CompaniesController::class, 'index']);
    Route::get('companies/{company}', [CompaniesController::class, 'show']);
    Route::get('events', [CareerController::class, 'redirectEvents']);
    Route::get('events/{academic_year}', [CareerController::class, 'events']);
});

Route::group(['prefix' => 'profile', 'middleware' => ['web', 'auth']], function ($router) : void {
    Route::get('/', [ProfileController::class, 'index']);

    Route::get('expenses', [ExpensesController::class, 'index']);
    Route::get('expenses/{year}/{month}', [ExpensesController::class, 'show']);
    // Route::get('settings', 'SettingsController::class, 'index');
    // Route::get('members', 'MembersController::class, 'index');
});

Route::get('/symposia/{symposium}/participants/{participant}', [
    ParticipantRegistrationController::class,
    'verify'
])->name('symposium.participant.verify')->middleware(['signed', 'throttle:6,1']);

Route::post('/symposia/{symposium}/participants', [
    ParticipantRegistrationController::class,
    'store'
])->middleware(['throttle:6,1', 'symposium-cors']);
