<?php

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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{do_id}', 'HomeController@view')->name('droplet');
Route::get('/create', 'HomeController@create')->name('blog-create');

Route::post('/subscribe', 'SubscriptionController@subscribe')->name('subscribe-user');

Route::get('/api/droplets', 'DropletController@index')->name('droplet-index');
Route::get('api/droplets/{do_id}/status', 'DropletController@status')->name('droplet-status');
Route::get('api/droplets/{do_id}/ip', 'DropletController@ip')->name('droplet-ip');

Route::post('/api/droplets/update/domain', 'DropletController@updateDomainName')->name('droplet-update-domain');

// Route::get('/images', function () {
//     return GrahamCampbell\DigitalOcean\Facades\DigitalOcean::image()->getAll();
// });
