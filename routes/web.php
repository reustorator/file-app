<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// аутентификация
Route::name('user.')->group(function (){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::get('/registration', [RegistrationController::class, 'index'])->name('registration');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/registration', [RegistrationController::class, 'register']);

    Route::get('/logout', function (){
        Auth::logout();
        return redirect('/');
    })->name('logout');
});

// профиль
Route::name('profile.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('index');
    Route::patch('/update_photo', [ProfileController::class, 'update_photo'])->name('update_photo');
    Route::delete('/delete_user/{id}', [AdminController::class, 'delete'])->name('delete');
});

// админ панель / пользователи
Route::name('admin.')->group(function () {
    Route::get('/admin-panel', [AdminController::class, 'show'])
        //->middleware('can:view-admin-panel') //посредник с отображением панели в навигации
        //->middleware('auth')
        ->name('show');
    Route::get('/edit_user/{user}', [AdminController::class, 'edit'])->name('edit');
    Route::get('/recovery_user/{id}', [AdminController::class, 'recovery'])->name('recovery');
    Route::post('/create_user', [AdminController::class, 'create'])->name('create');
    Route::patch('/update_user/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/delete_user/{id}', [AdminController::class, 'delete'])->name('delete');
});
