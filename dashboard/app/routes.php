<?php

$router->get('', 'IndexController@index');
$router->get('produto', 'ProdutoController@index');
$router->post('produto/alterar/visibilidade', 'ProdutoController@alterarVisibilidade');
$router->post('produto/alterar/status', 'ProdutoController@alterarStatus');
$router->get('cotacao/lista', 'ListaCotacaoController@index');
$router->post('cotacao/lista', 'ListaCotacaoController@index');
$router->post('cotacao/data', 'CotacaoDataController@index');
$router->post('cotacao/data/produto', 'CotacaoDataController@cotacaoProduto');
$router->get('cotacao/produto/lista', 'ListaCotacaoProdutoController@index');
$router->post('cotacao/produto', 'CotacaoProdutoController@index');
$router->post('cotacao/produto/selecionar', 'CotacaoProdutoController@selecionarCotacao');
$router->post('cotacao/produto/excluir', 'CotacaoProdutoController@excluirCotacao');
$router->get('cotacao/site/lista', 'ListaCotacaoSiteController@index');
$router->get('grafico/produto/lista', 'GraficoProdutoController@index');
$router->post('grafico/produto', 'GraficoProdutoController@grafico');
$router->get('erro', 'ListaErroController@index');
$router->get('crawler/sites', 'CrawlerController@listaSites');
$router->post('crawler', 'CrawlerController@realizaCotacao');