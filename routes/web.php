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

$router->post('/generateToken', 'UserController@generateToken');
$router->post('/login', 'UserController@login');

// I leave this shit outside Authentication so I can just call it from browser and debug faster
// @todo: move it inside middleware once done
$router->get('/invalidate-cache', 'HelperController@invalidateAll');


// Authentication through Token + username & Password
// Dont have any users tho LOL XD
$router->group(['middleware' => ['auth:api']], function () use ($router) {

    /**
     * Routes for users
     */

//    $router->get('/users/me', 'UserController@me');

});

// Authentication through Token
$router->group(['middleware' => ['client.credentials']], function () use ($router) {

    /**
     * Routes for Projects
     */
    $router->get('/projects', 'ProjectController@index');
    $router->get('/projects/{project}', 'ProjectController@show');
    $router->post('/projects', 'ProjectController@store');
    $router->put('/projects/{project}', 'ProjectController@update');
    $router->patch('/projects/{project}', 'ProjectController@update');
    $router->delete('/projects/{project}', 'ProjectController@destroy');


    /**
     * Routes for users
     */
//    $router->get('/users', 'UserController@index');
//    $router->post('/users', 'UserController@store');
//    $router->get('/users/me', 'UserController@me');
//    $router->put('/users/{user}', 'UserController@update');
//    $router->patch('/users/{user}', 'UserController@update');
//    $router->delete('/users/{user}', 'UserController@destroy');


});
