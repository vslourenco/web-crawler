<?php

namespace App\Controllers;

use App\Core\App;

class ListaCotacaoSiteController extends Controller
{	

	public function index()
	{
		$sites = App::get('database')->select("Select site.*, count(site.id) as quantidade 
			From site 
			Inner Join cotacao on id_site=site.id 
			Group By site.id");

		return view('site-lista', compact('sites'));
	}

}