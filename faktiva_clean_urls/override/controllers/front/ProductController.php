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

class ProductController extends ProductControllerCore
{
    public function init()
    {
        if ($product_rewrite = Tools::getValue('product_rewrite')) {
            $url_id_pattern = '/.*?([0-9]+)\-([a-zA-Z0-9-]*)(\.html)?/';
            $lang_id = (int) Context::getContext()->language->id;

            $sql = 'SELECT `id_product`
                FROM `'._DB_PREFIX_.'product_lang`
                WHERE `link_rewrite` = \''.pSQL(str_replace('.html', '', $product_rewrite)).'\' AND `id_lang` = '.$lang_id;
            if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                $sql .= ' AND `id_shop` = '.(int) Shop::getContextShopID();
            }

            $id_product = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
            if ($id_product > 0) {
                $_GET['id_product'] = $id_product;
            } elseif (preg_match($url_id_pattern, $this->request_uri, $url_parts)) {
                $sql = 'SELECT `id_product`
                    FROM `'._DB_PREFIX_.'product_lang`
                    WHERE `id_product` = \''.pSQL($url_parts[1]).'\' AND `id_lang` = '.$lang_id;
                if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
                    $sql .= ' AND `id_shop` = '.(int) Shop::getContextShopID();
                }

                $id_product = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
                if ($id_product > 0) {
                    $_GET['id_product'] = $id_product;
                }
            }
        }

        parent::init();
    }
}
