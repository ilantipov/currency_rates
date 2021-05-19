<?php


namespace App\Http\Controllers\Service;


use Illuminate\Support\Str;

class CurrencyDetector extends CurrencyBase
{

    public function getUserCurrnecyId(): int
    {
        if ($this->isRussia()) {
            return self::RUB;
        }

        return self::USD;
    }

    public function getPriceColumnName(): string
    {
        if ($this->isRussia()) {
            return self::PRICE_COLUMN_NAME_RUB;
        }
        return self::PRICE_COLUMN_NAME_USD;
    }

    /**
     * @return bool
     */
    public function isRussia(): bool
    {
        return false;
        $requestCountry = $_SERVER['GEOIP_COUNTRY_NAME'];
        //request()
        return Str::lower($requestCountry) == "россия" || Str::lower($requestCountry) == "russia";
    }
}
