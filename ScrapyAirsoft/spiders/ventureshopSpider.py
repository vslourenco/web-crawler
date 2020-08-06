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

class VentureShopSpider(CrawlSpider):
    name = "ventureshopSpider"
    
    rules = {
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('(//span[@class="page-next"]/a)[1]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//div[contains(@class, "component-search")]/div/ul/li/div/a')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(VentureShopSpider, self).__init__(*a, **kw)
        self.id_product=id_product
                   
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] = 8
        airsoft["title"] = response.xpath('//dt[@class="item"]/span[@itemprop="name"]/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('(//img[@class="photo"])[1]/@src').extract_first()
        airsoft["price"] = response.xpath('//div[contains(@class, "purchase-info")]/div/div[@class="price"]/em/@data-base-price').extract_first(default='99999')
        airsoft["discount_price"] = response.xpath('//div[contains(@class, "purchase-info")]/div/div[@class="price"]/small/b/text()').extract_first(default='99999')
        
        #airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
        
        yield airsoft
        
        
        
    