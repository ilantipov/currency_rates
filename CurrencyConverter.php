<?php

namespace App\Http\Controllers;

use App\Contracts\CurrencyExchangeLoaderContract;
use App\CurrencyExchangeRatio;
use App\Http\Controllers\Service\CurrencyBase;

class CurrencyConverter extends CurrencyBase
{
    private $currencyExchangeLoader = null;
    private $today = null;

    public function __construct(CurrencyExchangeLoaderContract $currencyExchangeLoader)
    {
        $this->currencyExchangeLoader = $currencyExchangeLoader;
        $this->today = today()->toDateString();
    }

    public function getExchangeRate(): float
    {
        $currencyExchangeRatio = (new CurrencyExchangeRatio())->whereActuality($this->today)->first();
        if (!$currencyExchangeRatio) {
            return $this->updateExchangeRate();
        }
        return $currencyExchangeRatio->value('ratio');
    }


    public function updateExchangeRate(): float
    {
        $newRatio = $this->currencyExchangeLoader->getCurrencyExchangeRate('USD');
        if (!empty($newRatio)) {
            $this->saveNewRatio($newRatio);
            return $newRatio;
        }
        throw new \Exception('No exchange ratio for today');
    }

    private function saveNewRatio(float $newRatio)
    {
        $currencyExchangeRatio = (new CurrencyExchangeRatio());

        $currencyExchangeRatio->actuality = $this->today;
        $currencyExchangeRatio->ratio = $newRatio;
        $currencyExchangeRatio->save();
    }
}
