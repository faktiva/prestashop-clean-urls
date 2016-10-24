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

class ManufacturerController extends ManufacturerControllerCore
{
    public function init()
    {
        if ($manufacturer_rewrite = Tools::getValue('manufacturer_rewrite')) {
            $sql = 'SELECT m.`id_manufacturer`
                FROM `'._DB_PREFIX_.'manufacturer` m
                LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
                WHERE m.`name` LIKE \''.pSQL(str_replace('-', '_', $manufacturer_rewrite)).'\'';
            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
            }

            $id_manufacturer = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_manufacturer > 0) {
                $_GET['id_manufacturer'] = $id_manufacturer;
            }
        }

        parent::init();
    }
}
