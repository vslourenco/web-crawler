<?php

Use App\Core\App;

set_time_limit(90);
ini_set('max_execution_time', 90);

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(Connection::make(App::get('config')['database'])));

function view($name, $data = [])
{
	extract($data);
	return require "app/views/{$name}.view.php";
}

function redirect($path)
{
	header("Location: /{$path}");
}

function dd($element)
{
	echo "<pre>";
	die(var_dump($element));
}

function montaURL($link, $imagem){
	if(strrpos($imagem, "http") !== false){
		return $imagem;
	}	
	if(strrpos($imagem, "//") !== false){
		return "http:".$imagem;
	}

	$pos = strpos($link, ".com.br");
	$site = substr($link, 0, $pos+7);
	
	return $site."/".$imagem;
}