<?php

namespace App\Controllers;

use App\Core\App;

class CotacaoProdutoController extends Controller
{	

	public function index()
	{
		$cotacoes = App::get('database')->select("Select * From cotacao 
			Where id_produto='{$_POST["produto"]}' AND ativo='1'
			Group By id
			Order By destaque DESC, preco_desconto ASC, data DESC");

		return view('produto-cotacao', compact('cotacoes'));
	}

	public function selecionarCotacao()
	{
		$cotacao = App::get('database')->select("Update cotacao SET destaque = '1' Where id='{$_POST["cotacao"]}'");

		redirect('');
	}

	public function excluirCotacao()
	{
		App::get('database')->execute("Update cotacao SET destaque = '0' Where id='{$_POST["cotacao"]}'");
		$cotacao = App::get('database')->delete("cotacao", $_POST["cotacao"]);

		redirect('');
	}
}