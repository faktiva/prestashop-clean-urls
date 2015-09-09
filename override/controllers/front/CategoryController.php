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
