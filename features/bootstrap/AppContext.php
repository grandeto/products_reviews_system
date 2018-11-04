<?php

use Behat\MinkExtension\Context\MinkContext;

class AppContext extends MinkContext
{
    /**
     * @BeforeSuite
     */
    public static function prepare(){
        shell_exec('php app/console doctrine:fixtures:load');
    }
}
