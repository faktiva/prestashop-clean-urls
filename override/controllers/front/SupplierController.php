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
