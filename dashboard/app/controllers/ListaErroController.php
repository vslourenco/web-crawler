<?php

namespace App\Controllers;

use App\Core\App;

class ListaErroController extends Controller
{	

	public function index()
	{
		$sites = App::get('database')->select("Select count(*) qtd_cotacoes, site.*, cotacao.data
			From site 
			Inner Join cotacao on id_site=site.id 
			Group By site.id, cotacao.data			
			Having qtd_cotacoes<10
			Order By cotacao.data DESC");

		return view('erro-lista', compact('sites'));
	}

}