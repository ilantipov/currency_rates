<?php


namespace App\Http\Controllers\Currencies;


use App\Contracts\CurrencyExchangeLoaderContract;
use Exception;
use Illuminate\Support\Carbon;

class CbrfCurrencyLoader implements CurrencyExchangeLoaderContract
{
    private const CBRF_BASE_URL = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=';
    private $url;
    private $today = null;
    private $list = [];


    public function __construct()
    {
        try {
            $this->today = Carbon::today()->format('d.m.Y');
            $this->url = self::CBRF_BASE_URL . $this->today;
            $xml = new \DOMDocument();
            if ($xml->load($this->url)) {
                $root = $xml->documentElement;
                $items = $root->getElementsByTagName('Valute');

                foreach ($items as $item) {
                    $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                    $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                    $this->list[$code] = floatval(str_replace(',', '.', $curs));
                }
            }
        }
        catch (Exception $exception){
            throw  new Exception($exception->getMessage());
        }
    }

    public function getCurrencyExchangeRate(string $currencyName): float
    {
        return isset($this->list[$currencyName]) ? (float) $this->list[$currencyName] : (float) 0;
    }


}
