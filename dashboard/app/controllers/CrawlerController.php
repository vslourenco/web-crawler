<?php

namespace App\Controllers;

use App\Core\App;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerController extends Controller
{	
	private $client;

	public function __construct(){
		$this->client = new Client([
			'curl' => [
			  CURLOPT_TCP_KEEPALIVE => 10,
			  CURLOPT_TCP_KEEPIDLE => 10
			]
		]);
	}

	public function listaSites(){
		$sites = App::get('database')->select("Select site.*, count(site.id) as quantidade 
			From site 
			Inner Join link on id_site=site.id 
			Group By site.id");

		return view('crawler-site-lista', compact('sites'));
	}

	public function realizaCotacao()
	{
		$links = App::get('database')->select("SELECT * FROM link WHERE id_site='{$_POST["site"]}' AND ativo='1'");
		
		foreach($links as $link){
			echo $link->url."<br>";
			$body = $this->getPage($link->url);
			$dados_site = false;
			switch($link->id_site)
			{
				case 1:
					$dados_site = $this->scrapeAventuramix($body);
					break;

				case 2:
					$dados_site = $this->scrapeDispropil($body);
					break;

				case 3:
					$dados_site = $this->scrapeFalconArmas($body);
					break;

				case 6:
					$dados_site = $this->scrapeMundoCarabina($body);
					break;

				case 8:
					$dados_site = $this->scrapeVentureshop($body);
					break;

				case 9:
					$dados_site = $this->scrapeLojaCarabina($body);
					break;
			}

			if ($dados_site) 
			{
                $cotacao = App::get('database')->execute("INSERT INTO `cotacao`
				(`data`, `id_produto`, `id_site`, `titulo`, `url`, `imagem`, `preco`, `preco_desconto`) 
				VALUES 
				(NOW(), '{$link->id_produto}', '{$link->id_site}', '{$dados_site["titulo"]}', '{$link->url}', '{$dados_site["imagem"]}', '{$dados_site["preco"]}', '{$dados_site["preco_desconto"]}')");
            }
		}

		redirect('crawler/sites');
		
	}

	private function getPage($url)
	{
		$response = $this->client->get($url, [
			'headers' => [
				'User-Agent' => 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36',
				'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
				'Accept-Encoding' => 'gzip, deflate, br'	 
			],
			'curl' => [
				CURLOPT_TCP_KEEPALIVE => 10,
				CURLOPT_TCP_KEEPIDLE => 10
			]
		]);
		$body = $response->getBody()->getContents();
		return new Crawler($body);
	}

	private function scrapeVentureshop($crawler)
	{	
		$preco = $crawler->filterXPath("//*[@class='prices']/strong/span")->text();
		$preco_desconto = $crawler->filterXPath("//*[@class='savings']/span[1]")->text();
		$titulo = $crawler->filterXPath("//h1[contains(@class, 'name')]")->text();
		$imagem = $crawler->filterXPath("//div[@class='zoom']/img")->attr("src");
		
		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco_desconto),
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}
	
	private function scrapeFalconArmas($crawler)
	{	
		$preco = $crawler->filterXPath("//div[contains(@class,'purchase-info')][1]/div[@class='content']/div/em/b")->text();
		$preco_desconto = $crawler->filterXPath("//div[contains(@class,'purchase-info')][1]/div[@class='content']/div/small/b")->text();
		$titulo = $crawler->filterXPath("//div[@class='breadcrumb']/h1/a")->text();
		$imagem = $crawler->filterXPath("//img[@id='img-product']")->attr("src");
		
		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco_desconto),
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}

	private function scrapeDispropil($crawler)
	{	
		$preco = $crawler->filterXPath("//p[@class='descricao-preco']/em[2]");
		if($preco->count() == 0)
		{
			return false;
		}
		$preco = $preco->text();
		$titulo = $crawler->filterXPath("//div[contains(@class,'productName')]")->text();
		$imagem = $crawler->filterXPath("//img[@id='image-main']")->attr("src");  

		$preco = str_replace("Por", "", $preco);
		$preco = str_replace(":", "", $preco);
		
		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco)*0.9,
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}
	
	private function scrapeMundoCarabina($crawler)
	{	
		$preco = $crawler->filterXPath("//p[@class='preco']/strong/span");
		if($preco->count() == 0)
		{
			return false;
		}
		$preco = $preco->text();
		$preco_desconto = $crawler->filterXPath("//span[@class='preco_avista_produto']")->text();
		$titulo = $crawler->filterXPath("//h1[@itemprop='name']")->text();
		$imagem = $crawler->filterXPath("//img[@id='imagem-principal']")->attr("src");
		
		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco_desconto),
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}
	
	private function scrapeAventuramix($crawler)
	{	
		$preco = $crawler->filterXPath("//b[@itemprop='price']")->text();
		$preco_desconto = $crawler->filterXPath("//div[@class='content']/div[@class='price']/small[@class='savings']/b[@class='instant-price']")->text();
		$titulo = $crawler->filterXPath("//span[@class='fn']")->text();
		$imagem = $crawler->filterXPath("//img[@id='img-product']")->attr("src");
	
		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco_desconto),
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}
	
	private function scrapeLojaCarabina($crawler)
	{	
		$preco = $crawler->filterXPath("//div[@id='credito']/ul/li[1]/span")->text();
		$preco_desconto = $crawler->filterXPath("//div[@id='boleto']/ul/li[1]/span")->text();
		$titulo = $crawler->filterXPath("//h1[@itemprop='name']")->text();
		$imagem = $crawler->filterXPath("//a[@id='zoom1']/img")->attr("src");

		return array(
			"preco" => $this->formatarMoeda($preco),
			"preco_desconto" => $this->formatarMoeda($preco_desconto),
			"titulo" => $titulo,
			"imagem" => $imagem
		);
	}

	private function formatarMoeda($valor)
	{
		$valor = str_replace("R", "", $valor);
		$valor = str_replace("$", "", $valor);
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", ".", $valor);

		return trim($valor);
	}

}