<?php

class CategoryController extends CategoryControllerCore
{
    public function init()
    {
         if ($category_rewrite = Tools::getValue('category_rewrite')) {
            $cat = explode("/",$_SERVER['REQUEST_URI']);
            /*
            $sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
                WHERE `link_rewrite` = \''.pSQL(str_replace('.html', '', $category_rewrite)).'\' AND `id_lang` = '.Context::getContext()->language->id;

             */
            $sql = 'SELECT `'._DB_PREFIX_.'category_lang`.`id_category` FROM `'._DB_PREFIX_.'category_lang` JOIN `'._DB_PREFIX_.'category` on `'._DB_PREFIX_.'category_lang`.`id_category` = `'._DB_PREFIX_.'category`.`id_category`
            WHERE `link_rewrite` = \''.pSQL(basename($category_rewrite, '.html')).'\' AND '
                . '((SELECT `link_rewrite` FROM `'._DB_PREFIX_.'category_lang` WHERE `id_category`=`id_parent`) = \''.$cat[count($cat)-2].'\''
                . ' OR (SELECT `link_rewrite` FROM `'._DB_PREFIX_.'category_lang` WHERE `id_category`=`id_parent`) = \'home\')'
                . ' AND `id_lang` = '.(int)Context::getContext()->language->id;

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
