<?php

class CmsController extends CmsControllerCore
{
    public function init()
    {
        $shop_sql = "";
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $shop_sql = ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
        }

        if ($cms_rewrite = Tools::getValue('cms_rewrite')) {
            $sql = 'SELECT l.`id_cms`
                FROM `'._DB_PREFIX_.'cms_lang` l
                LEFT JOIN `'._DB_PREFIX_.'cms_shop` s ON (l.`id_cms` = s.`id_cms`)
                WHERE l.`link_rewrite` = \''.pSQL(str_replace('.html', '', $cms_rewrite)).'\''.$shop_sql;

            $id_cms = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_cms > 0) {
                $_GET['id_cms'] = $id_cms;
            }
        } elseif ($cms_category_rewrite = Tools::getValue('cms_category_rewrite')) {
            $sql = 'SELECT l.`id_cms_category`
                FROM `'._DB_PREFIX_.'cms_category_lang` l
                LEFT JOIN `'._DB_PREFIX_.'cms_category_shop` s ON (l.`id_cms_category` = s.`id_cms_category`)
                WHERE `link_rewrite` = \''.pSQL(str_replace('.html', '', $cms_category_rewrite)).'\''.$shop_sql;

            $id_cms_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_cms_category > 0) {
                $_GET['id_cms_category'] = $id_cms_category;
            }
        }

        parent::init();
    }
}
