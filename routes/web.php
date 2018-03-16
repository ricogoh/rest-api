<?php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => env('API_VERSION').'/'], function () use ($router) {
    $router->get('/', function () use ($router) {
        return ['api' => env('API_VERSION')];
    });

    $router->post('login/', 'AuthController@login');
    $router->get('logout/', 'AuthController@logout');

    $router->get('users/', 'UserController@index');
    $router->get('users/{id}', 'UserController@show');
    $router->post('users/', 'UserController@create');
    $router->put('users/{id}', 'UserController@update');
    $router->delete('users/{id}', 'UserController@delete');

    $router->get('todos/', 'TodoController@index');
    $router->post('todos/', 'TodoController@store');
    $router->get('todos/{id}/', 'TodoController@show');
    $router->put('todos/{id}/', 'TodoController@update');
    $router->delete('todos/{id}/', 'TodoController@destroy');
});
