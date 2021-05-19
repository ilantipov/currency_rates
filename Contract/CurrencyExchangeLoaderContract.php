<?php


namespace App\Contracts;


interface CurrencyExchangeLoaderContract
{
    public function getCurrencyExchangeRate(string $currencyName): float;
}
