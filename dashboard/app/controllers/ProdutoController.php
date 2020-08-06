<?php

namespace App\Controllers;

use App\Core\App;

class ProdutoController extends Controller
{	

	public function index()
	{
		$produtos = App::get('database')->select("Select * 
			From airsoft 
			Group By airsoft.id");

		return view('produto-lista', compact('produtos'));
	}

	public function alterarVisibilidade()
	{
		$cotacao = App::get('database')->select("Update airsoft SET visivel = '{$_POST["nova_visibilidade"]}' Where id='{$_POST["produto"]}'");

		redirect('');
	}

	public function alterarStatus()
	{
		$cotacao = App::get('database')->select("Update airsoft SET ativo = '{$_POST["novo_status"]}' Where id='{$_POST["produto"]}'");

		redirect('');
	}

}