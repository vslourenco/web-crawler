<?php

namespace App\Controllers;

use App\Core\App;

class ListaCotacaoController extends Controller
{	

	public function index()
	{		
		$comp_sql = "";
		$site = "";
		if(isset($_POST["site"]) && $_POST["site"]!=""){
			$comp_sql .= "AND id_site='{$_POST["site"]}'";
			$site = $_POST["site"];
		}
		$cotacoes = App::get('database')->select("Select data, count(id) as quantidade From cotacao Where ativo='1' $comp_sql Group By data order by data desc");

		return view('cotacao-lista', compact('cotacoes', 'site'));
	}
}