<?php

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
    return "HTTP notification system";
});

// Publisher
Route::post('/publish/{topic}', 'PublisherController@publishToTopic');

// Subscriber
Route::post('/subscribe/{topic}', 'SubscriberController@subscribeToTopic');
Route::get('/getsubscribers/{topic}', 'SubscriberController@getAllSubscribers');
// Any other route apart from the previous 2 will be considered a subscriber route
Route::post('/{url}', 'SubscriberController@receiveData');
