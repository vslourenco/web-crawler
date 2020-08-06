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

class DispropilSpider(CrawlSpider):
    name = "dispropilSpider"
    
    rules = {
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//a[@rel="next"]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//div[@class="dp-prateleira"]//a[contains(@class,"productImage")]')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(DispropilSpider, self).__init__(*a, **kw)
        self.id_product=id_product
    
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] = 2
        airsoft["title"] = response.xpath('//div[contains(@class,"productName")]/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('//a[@id="botaoZoom"]/img/@src').extract_first()
        airsoft["price"] = response.xpath('//em[contains(@class, "valor-por")]/strong/text()').extract_first(default='99999')
        discount = response.xpath('//span[@class="msg-desconto"]/b/text()').extract_first(default='99999')
        if discount == '99999': 
            airsoft["discount_price"] = response.xpath('//strong[@class="skuBestPrice"]/text()').extract_first(default='99999')
        else:
            airsoft["discount_price"] = discount
        airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
        
        
       
        
        yield airsoft
        
        
        
    