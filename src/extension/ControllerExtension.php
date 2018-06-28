<?php

namespace SilverCommerce\CurrencySwitcher\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Session;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverCommerce\CurrencySwitcher\Helper\CurrencyHelper;

class ControllerExtension extends Extension
{
    public function onBeforeInit()
    {
        $symbol = getCurrencySymbol(CurrencyHelper::getActiveCurrency());

        $disallowed_controllers = [
            DevelopmentAdmin::class,
            DevBuildController::class,
            DatabaseAdmin::class
        ];

        // Don't run this during dev/build or dev/tasks
        if (!in_array(get_class($this->owner), $disallowed_controllers)) {
            DBCurrency::config()->currency_symbol = $symbol;
        }
    }
}