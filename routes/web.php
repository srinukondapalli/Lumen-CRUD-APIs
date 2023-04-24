<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

$router->get('/[/{user_id}]', 'CustomApi@get_userslist');
$router->get('/create', 'CustomApi@create_user');

$router->post('/register', 'AuthenticatedController@register');
$router->patch('/update', 'AuthenticatedController@update');
$router->delete('/delete', 'AuthenticatedController@delete');

### middleware authentication with api_token 
// $router->group(['prefix' => 'authApi','middleware' => 'auth'], function () use ($router) {
//     $router->get('list', 'CustomApi@get_userslist');
// });






