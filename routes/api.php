<?php

use App\Http\Controllers\API\WhatsappAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('wa')
    ->controller(WhatsappAPIController::class)
    ->group(function () {
        Route::get('/qr', 'qr');
        Route::post('/send/text', 'sendText');
        Route::post('/send/image', 'sendImage');
        Route::post('/send/video', 'sendVideo');
        Route::post('/send/document', 'sendDocument');
        Route::post('/send/audio', 'sendAudio');
        Route::post('/send/location', 'sendLocation');
        Route::post('/disconnect', 'disconnect');
    });

