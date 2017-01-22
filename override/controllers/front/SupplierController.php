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

class SupplierController extends SupplierControllerCore
{
    public function init()
    {
        if ($supplier_rewrite = Tools::getValue('supplier_rewrite')) {
            $sql = 'SELECT sp.`id_supplier`
                FROM `'._DB_PREFIX_.'supplier` sp
                LEFT JOIN `'._DB_PREFIX_.'supplier_shop` s ON (sp.`id_supplier` = s.`id_supplier`)
                WHERE sp.`name` LIKE \''.pSQL(str_replace('-', '_', $supplier_rewrite)).'\'';
            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
            }

            $id_supplier = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_supplier > 0) {
                $_GET['id_supplier'] = $id_supplier;
            }
        }

        parent::init();
    }
}
