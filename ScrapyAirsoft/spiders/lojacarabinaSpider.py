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

class LojaCarabinaSpider(CrawlSpider):
    name = "lojacarabinaSpider"
    
    rules = {
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('(//a[contains(@class, "next")])[1]'))),
            Rule(LinkExtractor(allow = (), restrict_xpaths= ('//li[contains(@class, "item")]/a')), callback = 'parse_item', follow = False )
            }
    
    def __init__(self, id_product, *a, **kw):
        super(LojaCarabinaSpider, self).__init__(*a, **kw)
        self.id_product=id_product
                   
    def parse_item(self, response):
        airsoft = ProductItem()
        airsoft["id_product"] = self.id_product
        airsoft["id_site"] =9
        airsoft["title"] = response.xpath('//div[@class="product-name"]/h1/text()').extract_first()
        airsoft["url"] = response.request.url
        airsoft["image"] = response.xpath('//a[@id="zoom1"]/@href').extract_first()
        airsoft["price"] = response.xpath('//div[@class="product-view"]/div/form/div/div[@class="price-box"]/span[@class="regular-price"]/span[@class="price"]/text()').extract_first(default='99999')
        airsoft["discount_price"] = response.xpath('//div[@class="product-view"]/div/form/div/div[@class="price-box"]/span[@class="regular-price"]/span[@class="price"]/text()').extract_first(default='99999')
        
        airsoft["price"] = GlobalTools.currencytoFloat(airsoft["price"])
        airsoft["discount_price"] = GlobalTools.currencytoFloat(airsoft["discount_price"])
        
        yield airsoft
        
        
        
    