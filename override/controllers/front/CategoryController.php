<?php

class CategoryController extends CategoryControllerCore
{
    public function init()
    {
        if ($category_rewrite = Tools::getValue('category_rewrite')) {
            $sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
                WHERE `link_rewrite` = \''.pSQL(str_replace('.html', '', $category_rewrite)).'\' AND `id_lang` = '.Context::getContext()->language->id;
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
