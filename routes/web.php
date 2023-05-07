<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session as FacadesSession;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('admin.index');
    }
    return view('login');
})->name('login');
Route::post('/authenticate', function (Request $request) {
    $email = $request->email;
    $password = $request->password;
    Auth::attempt(['email' => $email, 'password' => $password]);
    if (Auth::check()) {
        $request->session()->regenerate();
        return redirect()->route('admin.index');
    }
    FacadesSession::flash('error', 'Username atau password salah');
    return redirect()->route('admin.index');
})->name('authenticate');
Route::get('/', function (Request $request) {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::group([
    'middleware' => ['auth'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/', function () {
        return "Admin here";
    })->name('index');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
});