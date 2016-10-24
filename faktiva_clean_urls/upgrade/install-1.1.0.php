<?php

/*
 * This file is part of the "Prestashop Clean URLs" module.
 *
 * (c) Faktiva (http://faktiva.com)
 *
 * NOTICE OF LICENSE
 * This source file is subject to the CC BY-SA 4.0 license that is
 * available at the URL https://creativecommons.org/licenses/by-sa/4.0/
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
 * @license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
 * @source   https://github.com/faktiva/prestashop-clean-urls
 */

if (!defined('_PS_VERSION_')) {
    return;
}

function upgrade_module_1_1_0($module)
{
    $old_module = 'zzcleanurls';

    if (Module::isInstalled($old_module)) {
        Module::disableByName($this->name);

        die(Tools::displayError('You must first un-install module "ZiZuu Clean URLs"'));
    }

    Db::getInstance()->delete('module', "`name` = '$old_module'", 1);
    Db::getInstance()->delete('module_preference', "`module` = '$old_module'");
    Db::getInstance()->delete('configuration', "`name` LIKE '$old_module%'");
    Db::getInstance()->delete('quick_access', "`link` LIKE '%module_name=$old_module%'");

    return true;
}
