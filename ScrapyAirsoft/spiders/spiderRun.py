# -*- coding: utf-8 -*-
"""
Created on Wed Oct 17 22:24:56 2018

@author: Vinicius
"""
#scrapy crawl spiderRun

from twisted.internet import reactor, defer
from scrapy.crawler import CrawlerRunner
from scrapy.utils.log import configure_logging
from ScrapyAirsoft.spiders.aventuramixSpider import AventuramixSpider
from ScrapyAirsoft.spiders.dispropilSpider import DispropilSpider
from ScrapyAirsoft.spiders.falconarmaSpider import FalconArmaSpider
from ScrapyAirsoft.spiders.gmtaticoSpider import GMTaticoSpider
from ScrapyAirsoft.spiders.lojablowbackSpider import LojaBlowbackSpider
from ScrapyAirsoft.spiders.mundodacarabinaSpider import MundoDaCarabinaSpider
from ScrapyAirsoft.spiders.qgairsoftSpider import QGAairsoftSpider
from ScrapyAirsoft.spiders.ventureshopSpider import VentureShopSpider
from ScrapyAirsoft.spiders.lojacarabinaSpider import LojaCarabinaSpider
from scrapy.utils.project import get_project_settings
import logging

from ScrapyAirsoft import settings
import mysql.connector
from urllib.parse import quote_plus

configure_logging()
project_settings = get_project_settings()
runner = CrawlerRunner(project_settings)

@defer.inlineCallbacks
def crawl():
    connect = mysql.connector.connect(
      host = settings.MYSQL_HOST,
      user = settings.MYSQL_USER,
      passwd = settings.MYSQL_PASSWD,
      database = settings.MYSQL_DBNAME
    )
    
    cursor = connect.cursor();
    try:
        cursor.execute("SELECT * FROM `airsoft` WHERE ativo='1'")
        result = cursor.fetchall()

        for row in result:
            url_aventuramix="https://www.aventuramix.com.br/pesquisa/?p="+quote_plus(row[1])
            url_dispropil="https://www.dispropil.com.br/"+quote_plus(row[1]).replace('+', '%20')+"?PS=50&O=OrderByPriceASC"
            url_falconarma="https://www.falconarmas.com.br/pesquisa/?p="+quote_plus(row[1])
            url_gmtatico="https://www.gmtatico.com.br/?s="+quote_plus(row[1])+"&post_type=product"
            url_lojablowback="https://www.lojablowback.com.br/pesquisa/?p="+quote_plus(row[1])
            url_mundodacarabina="https://www.mundodacarabina.com.br/busca?q="+quote_plus(row[1])
            url_qgairsoft="https://www.qgairsoft.com.br/pesquisa/?p="+quote_plus(row[1])
            url_ventureshop="https://www.ventureshop.com.br/pesquisa/?p="+quote_plus(row[1])
            url_lojacarabina="https://www.lojadacarabina.com.br/catalogsearch/result/?q="+quote_plus(row[1])
            
            
            yield runner.crawl(AventuramixSpider, start_urls=[url_aventuramix], id_product=row[0])
            yield runner.crawl(DispropilSpider, start_urls=[url_dispropil], id_product=row[0])
            yield runner.crawl(FalconArmaSpider, start_urls=[url_falconarma], id_product=row[0])
            yield runner.crawl(GMTaticoSpider, start_urls=[url_gmtatico], id_product=row[0])
            yield runner.crawl(LojaBlowbackSpider, start_urls=[url_lojablowback], id_product=row[0])
            yield runner.crawl(MundoDaCarabinaSpider, start_urls=[url_mundodacarabina], id_product=row[0])
            yield runner.crawl(QGAairsoftSpider, start_urls=[url_qgairsoft], id_product=row[0])
            yield runner.crawl(VentureShopSpider, start_urls=[url_ventureshop], id_product=row[0])
            yield runner.crawl(LojaCarabinaSpider, start_urls=[url_lojacarabina], id_product=row[0])
            
            '''
            print(url_aventuramix)
            print(url_dispropil)
            print(url_falconarma)
            print(url_gmtatico)
            print(url_lojablowback)
            print(url_mundodacarabina)
            print(url_qgairsoft)
            print(url_ventureshop)
            print(url_lojacarabina)
            '''
            
    except Exception as error:
        logging.log(error)
    
    reactor.stop()

crawl()
reactor.run() # the script will block here until the last crawl call is finished