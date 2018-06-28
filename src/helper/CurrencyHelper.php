<?php

namespace SilverCommerce\CurrencySwitcher\Helper;

use SilverStripe\Control\Controller;

class CurrencyHelper
{
    /**
     * Return a list of currencies for use in the template
     *
     * @return void
     */
    public static function getAllCurrencies()
    {
        $currencies = null;

        /**
         * Currency Format
         * 
         * [
         *  'Code' => ''GBP',
         *  'Symbol' => '£',
         *  'Flag' => {ImageObject} // optional
         * ]
         */

        return $currencies;
    }

    public static function setCurrency($currency)
    {
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();

        $session->set('CommerceCurrency', $currency);
    }

    public static function getActiveCurrency()
    {
        $request = Injector::inst()->get(HTTPRequest::class);
        $session = $request->getSession();
        $currency = null;

        $currency = $session->get('CommerceCurrency');

        if (!$currency) {
            $member = Security::getCurrentUser();
            if ($member) {
                $currency = $member->CommerceCurrency;
            } else {
                $config = SiteConfig::current_site_config();

                // Now find and set the desired currency symbol
                $number_format = new NumberFormatter($config->SiteLocale, NumberFormatter::CURRENCY);
                $currency = $number_format->getTextAttribute(NumberFormatter::CURRENCY_CODE);
            }
        }

        return $currency;
    }

    public static function getLocalCurrency()
    {

    }

    public static function getCurrencySymbol($currency)
    {

    }

    public function convertCurrency($value, $from, $to)
    {
        
    }


}