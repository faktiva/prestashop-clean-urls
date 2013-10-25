<?php

class ProductController extends ProductControllerCore
{
	public function init()
	{
		if (Tools::getValue('product_rewrite'))
		{
			//$url_id_pattern = '/[a-zA-Z0-9-]*\/([0-9]+)\-([a-zA-Z0-9-]*)\.html/';
			$url_id_pattern = '/.*?([0-9]+)\-([a-zA-Z0-9-]*)\.html/';
			$rewrite_url = Tools::getValue('product_rewrite');

			$sql = 'SELECT `id_product`
				FROM `'._DB_PREFIX_.'product_lang`
				WHERE `link_rewrite` = \''.$rewrite_url.'\' AND `id_lang` = '. Context::getContext()->language->id;

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
			}

			$id_product = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
				
			if($id_product > 0)
			{
				$_GET['id_product'] = $id_product;
			}
			else if(preg_match($url_id_pattern, $_SERVER['REQUEST_URI'], $url_split))
			{
				$url_id_product = $url_split[1];

				$sql = 'SELECT `id_product`
					FROM `'._DB_PREFIX_.'product_lang`
					WHERE `id_product` = \''.$url_id_product.'\' AND `id_lang` = '. Context::getContext()->language->id;

				if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				{
					$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
				}
					
				$id_product = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

				if($id_product > 0)
				{
					$_GET['id_product'] = $id_product;
				}
				else
				{
					//TODO: Do we need to send 404?
					header('HTTP/1.1 404 Not Found');
					header('Status: 404 Not Found');
				}
			}
			else
			{
				//TODO: Do we need to send 404?
				header('HTTP/1.1 404 Not Found');
				header('Status: 404 Not Found');
			}
		}
		parent::init();
	}
}
