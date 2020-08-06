<?php

Use App\Core\{Router, Request};

require 'vendor/autoload.php';
require 'core/bootstrap.php';

$uri = Request::uri();
$method = Request::method();

Router::load('app/routes.php')
	->direct($uri, $method);