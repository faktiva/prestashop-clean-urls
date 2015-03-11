<?php

class CategoryController extends CategoryControllerCore
{
	public function init()
	{
		if (Tools::getValue('category_rewrite'))
		{
			// SQL safe?
			$category_rewrite = Tools::getValue('category_rewrite');

			$sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
					WHERE `link_rewrite` = \''.$category_rewrite.'\' AND `id_lang` = '. Context::getContext()->language->id;

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
			}
			
			$id_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

			if($id_category > 0)
			{
				$_GET['id_category'] = $id_category;
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
