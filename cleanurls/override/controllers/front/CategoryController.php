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

			$categorys_list = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
			$categorys_count = count($categorys_list);

			if($categorys_count == 1)
			{
				// Found ONLY one so dont need to look for parent
				$id_category = (int)$categorys_list[0]['id_category'];
				$_GET['noredirect'] = TRUE;
			}
			else if($categorys_count > 1)
			{
				// Found more than one so look for parent
				// SQL safe?
				$parent_rewrite = Tools::getValue('categories_rewrite');

				$shop_id = (int)Shop::getContextShopID();
				$sql = 'SELECT c.`id_category`
						FROM `ps_category` c
						LEFT JOIN `ps_category_lang` cl ON (c.`id_category` = cl.`id_category` AND cl.id_shop = '. $shop_id .' )
							INNER JOIN ps_category_shop category_shop ON (category_shop.id_category = c.id_category AND category_shop.id_shop = '. $shop_id .')
						LEFT JOIN `ps_category_lang` clp ON (c.`id_parent` = clp.`id_category`)
						WHERE cl.`link_rewrite` = \''.$category_rewrite.'\'
							AND clp.`link_rewrite` = \''.$parent_rewrite.'\'
							AND cl.`id_lang` = '. Context::getContext()->language->id;

				$id_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
				$_GET['noredirect'] = TRUE;
			}
			else
			{
				// none found
				$id_category = 0;
			}

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
