<?php

class ManufacturerController extends ManufacturerControllerCore
{
	public function init()
	{
		if (Tools::getValue('manufacturer_rewrite'))
		{
			$name_manufacturer = str_replace('-', '%', Tools::getValue('manufacturer_rewrite'));

			//
			// TODO:: need to core update Prestashop code and 
			// DB for link_rewrite for manufacturers
			// Should we use the Mysql FullText Index Search ??
			//
			$sql = 'SELECT m.`id_manufacturer`
				FROM `'._DB_PREFIX_.'manufacturer` m
				LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
				WHERE m.`name` LIKE \''.$name_manufacturer.'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			{
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
			}

			$id_manufacturer = Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

			if($id_manufacturer > 0)
			{
				$_GET['id_manufacturer'] = $id_manufacturer;
				$_GET['noredirect'] = 1;
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
