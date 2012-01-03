<?php
require_once 'Views/Twig/Autoloader.php';
Twig_Autoloader::register();

require 'Slim/Slim.php';
require 'Views/TwigView.php';
require 'lib/database.php';

$app = new Slim(array('view' => 'TwigView', 'http.version' => '1.0'));

$app->get('/', function() use($app) {
	$app->redirect('wishlist');
});

$app->get('/wishlist(/:order)', function($order = 'year') use($app) {
	$app->etag('wishlist');

	$albums = Database::getAlbums('wishlist', $order);
	$data = array('albums' => $albums, 'page' => 'wishlist', 'order' => $order);

	$app->render('index.html', $data);
});

$app->get('/coleccao(/:order)', function($order = 'year') use($app) {
	$app->etag('coleccao');

	$albums = Database::getAlbums('collection', $order);
	$data = array('albums' => $albums, 'page' => 'coleccao', 'order' => $order);

	$app->render('index.html', $data);
});

$app->run();
