# -*- coding: utf-8 -*-
"""
Created on Sun Oct 14 11:43:37 2018

@author: Vinicius
"""

class GlobalTools:
    
    def currencytoFloat(currency):
        currency=currency.replace("R$","")
        currency=currency.replace("*","")
        currency=currency.replace("à vista","")
        currency=currency.replace(" ","")
        currency=currency.replace("*","")
        currency=currency.replace(".","")
        currency=currency.replace(",",".")
        currency=float(currency)
        
        return currency