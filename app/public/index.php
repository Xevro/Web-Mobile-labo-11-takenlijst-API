<?php

// General variables
require __DIR__ . '/../vendor/autoload.php';

// Create Router instance
$router = new \Bramus\Router\Router();

$router->setNamespace('\Http');

$router->get('/', function() {
    readfile('home.html');
});

$router->mount('/api', function() use ($router) {

    $router->get('/tasks', 'TaskController@overview');
    $router->post('/tasks', 'TaskController@addTask');
    $router->get('/tasks/(\d+)', 'TaskController@getTask');
    $router->put('/tasks/(\d+)', 'TaskController@editTask');
    $router->patch('/tasks/(\d+)', 'TaskController@methodNotAllowed');
    $router->delete('/tasks/(\d+)', 'TaskController@delete');

});
// Run it!
$router->run();
