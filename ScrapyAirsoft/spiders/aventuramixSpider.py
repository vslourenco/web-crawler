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

class AventuramixSpider(CrawlSpider):
    name = "aventuramixSpider"
    
    rules = {
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('(//span[@class="page-next"])[1]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//h3[@class="product-name"]/a')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(AventuramixSpider, self).__init__(*a, **kw)
        self.id_product=id_product
                   
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] = 1
        airsoft["title"] = response.xpath('//dt[@class="item"]/span[@class="fn"]/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('//img[@id="img-product"]/@src').extract_first()
        airsoft["price"] = response.xpath('//em[@class="sale-price"]/b[@itemprop="price"]/@content').extract_first(default='99999')
        airsoft["discount_price"] = response.xpath('//div[@class="content"]/div[@class="price"]/small/b[@class="instant-price"]/text()').extract_first(default='99999')
        
        #airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
        
        yield airsoft
        
        
        
    