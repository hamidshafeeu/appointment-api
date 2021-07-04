<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{any}', HomeController::class)->where('any', '.*');

