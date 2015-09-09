<?php

/*
 * This file is part of the zzCleanURLs module.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   ZiZuu.com <info@zizuu.com>
 * @source   https://github.com/ZiZuu-store/zzCleanURLs
 */

class ManufacturerController extends ManufacturerControllerCore
{
    public function init()
    {
        if ($manufacturer_rewrite = Tools::getValue('manufacturer_rewrite')) {
            $manufacturer_rewrite = str_replace('-', '%', $manufacturer_rewrite);

            $sql = 'SELECT m.`id_manufacturer`
                FROM `'._DB_PREFIX_.'manufacturer` m
                LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
                WHERE m.`name` LIKE \''.pSQL($manufacturer_rewrite).'\'';

            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
            }

            $id_manufacturer = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_manufacturer > 0) {
                $_GET['id_manufacturer'] = $id_manufacturer;
                $_GET['noredirect'] = 1;
            }
        }

        parent::init();
    }
}
