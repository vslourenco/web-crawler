<?php

namespace App\Controllers;

use App\Core\App;

class GraficoProdutoController extends Controller
{	

	public function index()
	{
		$produtos = App::get('database')->select("Select airsoft.*, count(airsoft.id) as quantidade 
			From airsoft 
			Inner Join cotacao on id_produto=airsoft.id 
			Where destaque='1' AND cotacao.ativo='1' AND visivel = 1
			Group By airsoft.id");

		return view('grafico-produto-lista', compact('produtos'));
	}

	public function grafico()
	{
		$produto = App::get('database')->select("Select * From airsoft Where id='{$_POST["produto"]}'")[0];

		$cotacoes = App::get('database')->select("Select * From cotacao 
			Where id_produto='{$_POST["produto"]}' AND ativo='1' AND destaque='1'
			Group By id
			Order By data ASC");

		return view('grafico-produto', compact('cotacoes', 'produto'));
	}


}