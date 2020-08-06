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

class LojaBlowbackSpider(CrawlSpider):
    name = "lojablowbackSpider"
    
    rules = {
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('(//span[@class="page-next"]/a)[1]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//div[contains(@class, "component-search")]/div/ul/li/div/a')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(LojaBlowbackSpider, self).__init__(*a, **kw)
        self.id_product=id_product
    
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] = 5
        airsoft["title"] = response.xpath('//dt[@class="item"]/span/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('(//img[@class="photo"]/@src)[1]').extract_first()
        airsoft["price"] = response.xpath('//b[@itemprop="price"]/@content').extract_first(default='99999')
        airsoft["discount_price"] = response.xpath('(//div[contains(@class,"purchase-info")])[1]/div[@class="content"]/div[@class="price"]/small/b/text()').extract_first(default='99999')
        
        #airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
                    
        yield airsoft
        
        
        
    