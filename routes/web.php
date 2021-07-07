<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\HomeController;
use App\Models\Booking;
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

Route::get('/appointment/{booking:hash}', function (Booking $booking) {
    return view('qr', compact('booking'));
})->name('booking.view');

Route::prefix('admin')->group(function ($router) {
    $router->get('/auth', [AdminHomeController::class, 'auth']);
    $router->post('/auth', [AdminHomeController::class, 'sendAuthLink'])->name('admin.sendLink');
    $router->get('/authenticate/{token}', [AdminHomeController::class, 'authenticate'])->name('admin.authenticate')->where('token', '.*');

    Route::middleware('make-sure-admin')->group(function ($router) {
        $router->get('/', [AdminHomeController::class, 'index']);
        $router->post('/re-send', [AdminHomeController::class, 'resend'])->name('resend');
        $router->post('/de-auth', [AdminHomeController::class, 'logout'])->name('admin.logout');
    });
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', HomeController::class)->where('any', '.*');

