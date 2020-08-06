<?php

namespace App\Controllers;

use App\Core\App;
 
class IndexController extends Controller
{	
	function index()
	{
		$cotacoes = App::get('database')->select("Select * From cotacao 
			Inner Join airsoft on id_produto=airsoft.id
			Where destaque='1' AND cotacao.ativo='1'
			Group By cotacao.id
			Order By data DESC, preco_desconto ASC 
			LIMIT 20");

		return view('index', compact('cotacoes'));
	}
}