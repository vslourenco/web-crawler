# -*- coding: utf-8 -*-

# Define here the models for your scraped items
#
# See documentation in:
# https://doc.scrapy.org/en/latest/topics/items.html

import scrapy


class ScrapyairsoftItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
    pass

class ProductItem(scrapy.Item):
    id_product = scrapy.Field()
    id_site = scrapy.Field()
    title = scrapy.Field()
    url = scrapy.Field()
    image = scrapy.Field()
    price = scrapy.Field()
    discount_price = scrapy.Field()
    
