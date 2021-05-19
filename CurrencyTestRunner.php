<?php


namespace App\Http\Controllers\Service;


use App\Http\Controllers\Currencies\CbrfCurrencyLoader;
use App\Http\Controllers\CurrencyConverter;

class CurrencyTestRunner
{
    public function test()
    {
       dd( (new CurrencyConverter(new CbrfCurrencyLoader()))->getExchangeRate())   ;
       dd( (new CurrencyConverter(new CbrfCurrencyLoader()))->updateExchangeRate())   ;
}
}
