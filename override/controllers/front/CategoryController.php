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
 *  @author      ZiZuu.com <info@zizuu.com>
 *  @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  @source      https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

class CategoryController extends CategoryControllerCore
{
    public function init()
    {
        if ($category_rewrite = Tools::getValue('category_rewrite')) {
            $sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
                WHERE `link_rewrite` = \''.pSQL($category_rewrite).'\' AND `id_lang` = '.Context::getContext()->language->id;

            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
            }

            $id_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_category > 0) {
                $_GET['id_category'] = $id_category;
            }
        }

        parent::init();
    }
}
