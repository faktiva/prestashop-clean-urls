<?php

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   ZiZuu.com <info@zizuu.com>
 * @license  http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @source   https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

class SupplierController extends SupplierControllerCore
{
    public function init()
    {
        if ($supplier_rewrite = Tools::getValue('supplier_rewrite')) {
            $supplier_rewrite = str_replace('-', '%', $supplier_rewrite);

            $sql = 'SELECT sp.`id_supplier`
                FROM `'._DB_PREFIX_.'supplier` sp
                LEFT JOIN `'._DB_PREFIX_.'supplier_shop` s ON (sp.`id_supplier` = s.`id_supplier`)
                WHERE sp.`name` LIKE \''.pSQL($supplier_rewrite).'\'';

            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
            }

            $id_supplier = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_supplier > 0) {
                $_GET['id_supplier'] = $id_supplier;
            }
        }

        parent::init();
    }
}
