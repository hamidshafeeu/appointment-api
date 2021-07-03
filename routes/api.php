<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaticResourcesController;
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

Route::middleware('api-auth')->group(function($router) {
    $router->post('/otp', [AuthController::class, 'otp']);
    $router->post('/re-otp', [AuthController::class, 'otp_resend']);

    $router->get('/atolls', [StaticResourcesController::class, 'atolls']);
    $router->get('/atolls/{id}/islands', [StaticResourcesController::class, 'atoll_islands']);
    $router->get('/islands', [StaticResourcesController::class, 'islands']);
    $router->get('/island/{id}/centers', [StaticResourcesController::class, 'island_centers']);
    $router->get('/center/{id}/dates', [StaticResourcesController::class, 'center_dates']);
    $router->get('/center/{id}/{date}/slots', [StaticResourcesController::class, 'center_date_slots']);

    $router->post('/appointment', AppointmentController::class);
});
