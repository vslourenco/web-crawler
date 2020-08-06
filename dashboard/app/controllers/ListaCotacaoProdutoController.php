<?php

namespace App\Controllers;

use App\Core\App;

class ListaCotacaoProdutoController extends Controller
{	

	public function index()
	{
		$produtos = App::get('database')->select("Select airsoft.*, count(airsoft.id) as quantidade 
			From airsoft 
			Inner Join cotacao on id_produto=airsoft.id 
			Where visivel = 1
			Group By airsoft.id");

		return view('cotacao-produto-lista', compact('produtos'));
	}

}