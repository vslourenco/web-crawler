# -*- coding: utf-8 -*-
"""
Created on Sat Oct 13 18:22:20 2018

@author: Vinicius
"""

import scrapy
from scrapy.spiders import CrawlSpider, Rule
from scrapy.linkextractors import LinkExtractor

from ScrapyAirsoft.items import ProductItem
from ..globalTools import GlobalTools

class MundoDaCarabinaSpider(CrawlSpider):
    name = "mundodacarabinaSpider"
    
    rules = {
            #Rule(LinkExtractor(allow = (), restrict_xpaths= ('(//span[@class="page-next"]/a)[1]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//div[contains(@class, "paginacao_infinita")]/div/div/div/div/h2/a')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(MundoDaCarabinaSpider, self).__init__(*a, **kw)
        self.id_product=id_product
    
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] = 6
        airsoft["title"] = response.xpath('//h1/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('//img[@id="imagem-principal"]/@src').extract_first()
        airsoft["price"] = response.xpath('//p[@class="preco"]/strong/text()').extract_first(default='99999')
        airsoft["discount_price"] = response.xpath('//div[@class="dados_compra"]/p[@class="parcelamento"]/strong/text()').extract_first(default='99999')
        
        airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
                    
        yield airsoft
        
        
        
    