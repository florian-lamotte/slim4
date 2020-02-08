<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Selective\BasePath\BasePathMiddleware;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

// Add middleware
$app->addRoutingMiddleware();

// Set the base path to run the app in a subdirectory.
// This path is used in urlFor().
$app->add(new BasePathMiddleware($app));

// (false, true, true) pour enlever l'affichage des erreurs en production
// http://www.slimframework.com/docs/v4/deployment/deployment.html
$app->addErrorMiddleware(true, true, true);

$container->set('view', function () {
    return new PhpRenderer('../templates');
});

$container->set('db', function () {
    $host = 'localhost';
    $dbname = 'slim3';
    $name = 'root';
    $pass = '';

    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $name, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    return $pdo;
});

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello world!");
    return $response;
});

$app->get('/posts', function (Request $request, Response $response) {
	// https://packagist.org/packages/slim/php-view
	// php-view ne fourni pas de protection XSS, 
	// utiliser htmlspecialchars() ou https://github.com/slimphp/Twig-View

    $req = $this->get('db')->query('SELECT * FROM posts');
	$posts = $req->fetchAll();

    $response = $this->get('view')->render($response, "posts.php", ['posts' => $posts]);
    return $response;
});

$app->get('/post/{id}', function (Request $request, Response $response, $args) {
	$id = $args['id'];
    $response->getBody()->write("Message n°$id.");
    return $response;
});

$app->run();
