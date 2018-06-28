<?php

namespace SilverCommerce\CurrencySwitcher\Extensions;

use Locale;
use NumberFormatter;
use SilverStripe\Dev\Debug;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\DropdownField;

class MemberExtension extends DataExtension
{
    private static $db = [
        "CommerceCurrency" => "Varchar(3)",
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            "Root.Main",
            DropdownField::create(
                "CommerceCurrency",
                $this->owner->fieldLabel("Currency"),
                $this->getCurrencies()
            )->setEmptyString('pick one'),
            'FailedLoginCount'
        );
    }

    public function getCurrencies()
    {
        $locales = i18n::getSources()->getKnownLocales();
        $currencies = [];

        foreach ($locales as $key => $value) {
            // Now find and set the desired currency symbol
            $number_format = new NumberFormatter($key, NumberFormatter::CURRENCY);
            $symbol = $number_format->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
            $name = $number_format->getTextAttribute(NumberFormatter::CURRENCY_CODE);
            if (!isset($currencies[$name])) {
                $currencies[$name] = $symbol.' ('.$name.')';
            }
        }

        return $currencies;
    }

    public function populateDefaults()
    {
        $number_format = new NumberFormatter(i18n::get_locale(), NumberFormatter::CURRENCY);
        $name = $number_format->getTextAttribute(NumberFormatter::CURRENCY_CODE);

        $this->owner->CommerceCurrency = $name;
    }

    public function onBeforeWrite()
    {
        if (!$this->owner->CommerceCurrency) {
            $number_format = new NumberFormatter($this->owner->Locale, NumberFormatter::CURRENCY);
            $name = $number_format->getTextAttribute(NumberFormatter::CURRENCY_CODE);

            $this->owner->CommerceCurrency = $name;
        }
    }
}
