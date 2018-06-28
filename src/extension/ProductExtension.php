<?php

namespace SilverCommerce\CurrencySwitcher\Extensions;

use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverCommerce\CurrencySwitcher\Helper\CurrencyHelper;

class ProductExtension extends DataExtension
{
    public function updatePrice(&$price)
    {
        $new_price = $this->convertCurrency($price);

        return $new_price;
    }

    public function updateTaxAmount(&$tax)
    {
        $new_tax = $this->convertCurrency($tax);

        return $new_tax;
    }

    public function convertCurrency($value)
    {
        // First check to see if currency needs converting
        $local_currency = CurrencyHelper::getLocalCurrency();
        $active_currency = CurrencyHelper::getActiveCurrency();
        if ($local_currency != $active_currency) {
            CurrencyHelper::convertCurrency(
                $value, 
                $local_currency, 
                $active_currency
            );
        } else {
            return $value;
        }
    }
}