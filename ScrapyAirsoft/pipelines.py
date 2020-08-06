# -*- coding: utf-8 -*-

# Define your item pipelines here
#
# Don't forget to add your pipeline to the ITEM_PIPELINES setting
# See: https://doc.scrapy.org/en/latest/topics/item-pipeline.html

import mysql.connector
import datetime
import logging

from ScrapyAirsoft import settings

class ScrapyAirsoftPipeline(object):
    
    def __init__(self):
        self.connect = mysql.connector.connect(
          host = settings.MYSQL_HOST,
          user = settings.MYSQL_USER,
          passwd = settings.MYSQL_PASSWD,
          database = settings.MYSQL_DBNAME
        )
        
        self.cursor = self.connect.cursor();
        
    def process_item(self, item, spider):
        try:
            self.cursor.execute(
                "INSERT INTO `cotacao`(`data`, `id_produto`, `id_site`, `titulo`, `url`, `imagem`, `preco`, `preco_desconto`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                (
                    datetime.datetime.now(),
                    item['id_product'],
                    item['id_site'],
                    item['title'],
                    item['url'],
                    item['image'],
                    item['price'],
                    item['discount_price']
                 ))
            self.connect.commit()
        except Exception as error:
            logging.log(error)
        return item

    def close_spider(self, spider):
        self.connect.close();