<?php
header('Access-Control-Allow-Origin: *');   
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
require '../vendor/autoload.php';
$config = [
    'settings' => [
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        "determineRouteBeforeAppMiddleware" => true
    ],
];
$app = new \Slim\App($config);
$container = $app->getContainer();
$container['view'] = __DIR__ . '/../templates/';

$container['db'] = function ($c) {
    $connection = new PDO('mysql:host=localhost;post=3306;dbname=automated_restaurant', 'root', '123456');
    return $connection;
};

$app->group('', function () use ($app) {
    $app->group('/api', function () use ($app) {
        $app->group('/login', function () use ($app) {
            $app->post('',  \admincontroller::class . ':login');
        });
        $app->group('/waiter', function () use ($app){
            $app->group('/table_status', function () use ($app){
                $app->get('',  \homecontroller::class . ':check_table_status');
            });
            $app->group('/menu', function () use ($app){
                $app->group('/kind', function () use ($app){
                    $app->get('', \homecontroller::class . ':get_food_kind');
                    $app->post('', \homecontroller::class . ':post_new_kind');
                    $app->patch('', \homecontroller::class . ':patch_kind');
                    $app->delete('', \homecontroller::class . ':delete_kind');
                });
                $app->get('s', \homecontroller::class . ':retrieve_menu_info');
                $app->get('', \homecontroller::class . ':retrieve_menu_info');

                $app->group('/food', function () use ($app){
                    $app->get('', \homecontroller::class . ':retrieve_specify_food');
                    $app->post('', \homecontroller::class . ':post_new_food');
                });
            });   
        });

        $app->group('/photo', function() use ($app){
            $app->get('', \admincontroller::class . ':get_picture');
            $app->post('', \admincontroller::class . ':upload_picture');
            $app->delete('', \admincontroller::class . ':remove_picture');
        }); 
    });
});

$app->run();
