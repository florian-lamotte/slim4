<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Add middleware
$app->addRoutingMiddleware();

// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));

// (false, true, true) pour enlever l'affichage des erreurs en production
// http://www.slimframework.com/docs/v4/deployment/deployment.html
$app->addErrorMiddleware(true, true, true);

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/posts', function (Request $request, Response $response) {
    $response->getBody()->write("Tous les messages.");
    return $response;
});

$app->get('/post/{id}', function (Request $request, Response $response, $args) {
	$id = $args['id'];
    $response->getBody()->write("Message n°$id.");
    return $response;
});

$app->run();
