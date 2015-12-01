<?php

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
                $sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
            }

            $id_manufacturer = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_manufacturer > 0) {
                $_GET['id_manufacturer'] = $id_manufacturer;
            }
        }

        parent::init();
    }
}
