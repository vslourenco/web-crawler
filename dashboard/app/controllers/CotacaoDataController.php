<?php

namespace App\Controllers;

use App\Core\App;

class CotacaoDataController extends Controller
{	

	public function index()
	{			
		$comp_sql = "";
		$site = "";
		if(isset($_POST["site"]) && $_POST["site"]!=""){
			$comp_sql .= "AND id_site='{$_POST["site"]}'";
			$site = $_POST["site"];
		}
		$cotacoes = App::get('database')->select("Select airsoft.nome, airsoft.imagem, count(cotacao.id) as quantidade, cotacao.data, airsoft.id From cotacao 
			Inner Join airsoft on id_produto=airsoft.id 
			Where cotacao.ativo='1' AND cotacao.data='{$_POST["data"]}' $comp_sql
			Group By id_produto");

		return view('cotacao-data', compact('cotacoes', 'site'));
	}

	public function cotacaoProduto()
	{
		$data = $_POST["data"];		
		$comp_sql = "";
		$site = "";
		if(isset($_POST["site"]) && $_POST["site"]!=""){
			$comp_sql .= "AND id_site='{$_POST["site"]}'";
			$site = $_POST["site"];
		}
		$cotacoes = App::get('database')->select("Select * From cotacao 
			Where cotacao.ativo='1' AND cotacao.data='{$data}' AND id_produto='{$_POST["produto"]}' $comp_sql
			Group By id
			Order By destaque DESC, data DESC, preco_desconto ASC");

		return view('cotacao-data-produto', compact('cotacoes', 'data'));
	}
}