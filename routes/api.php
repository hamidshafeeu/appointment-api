<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\SlotsController;
use App\Http\Controllers\StaticResourcesController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/begin', [AuthController::class, 'begin'])->middleware('throttle:10,1');
Route::post('/let-us-know', TicketController::class)->middleware('throttle:10,1');

Route::middleware('api-auth:pre-otp')->group(function($router) {
    $router->post('/otp', [AuthController::class, 'otp']);
    $router->post('/re-otp', [AuthController::class, 'otp_resend']);
});

Route::middleware('api-auth:post-otp')->group(function($router) {
    $router->get('/mine', [StaticResourcesController::class, 'mine']);
    $router->get('/centers', [StaticResourcesController::class, 'centers']);
    $router->get('/atolls', [StaticResourcesController::class, 'atolls']);
    $router->get('/atolls/{id}/islands', [StaticResourcesController::class, 'atoll_islands']);
    $router->get('/islands', [StaticResourcesController::class, 'islands']);
    $router->get('/island/{id}/centers', [StaticResourcesController::class, 'island_centers']);
    $router->get('/center/{id}/dates', [StaticResourcesController::class, 'center_dates']);
    $router->get('/center/{id}/{date}/slots', [StaticResourcesController::class, 'center_date_slots']);
    $router->post('/appointment/{booking}/cancel', [AppointmentController::class, 'cancel']);
    $router->post('/appointment', [AppointmentController::class, 'store']);
});

Route::middleware('admin')->group(function($router) {
    $router->post('/slots', SlotsController::class);
    $router->patch('/slots', [CacheController::class, 'updateSlots']);
    $router->post('/centers', [CacheController::class, 'updateCenters']);
});
