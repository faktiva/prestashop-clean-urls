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

class CategoryController extends CategoryControllerCore
{
    public function init()
    {
        if ($category_rewrite = Tools::getValue('category_rewrite')) {
            $sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
                WHERE `link_rewrite` = \''.pSQL(str_replace('.html', '', $category_rewrite)).'\' AND `id_lang` = '.Context::getContext()->language->id;
            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND `id_shop` = '.(int) Shop::getContextShopID();
            }

            $id_category = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_category > 0) {
                $_GET['id_category'] = $id_category;
            }
        }

        parent::init();
    }
}
