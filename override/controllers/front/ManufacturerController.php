<?php

/**
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   ZiZuu.com <info@zizuu.com>
 * @license  http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @source   https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

class ManufacturerController extends ManufacturerControllerCore
{
	public function init()
	{
		if ($manufacturer_rewrite = Tools::getValue('manufacturer_rewrite'))
		{
			$manufacturer_rewrite = str_replace('-', '%', $manufacturer_rewrite);

			$sql = 'SELECT m.`id_manufacturer`
				FROM `'._DB_PREFIX_.'manufacturer` m
				LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
				WHERE m.`name` LIKE \''.pSQL($manufacturer_rewrite).'\'';

			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();

			$id_manufacturer = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			if ($id_manufacturer > 0)
			{
				$_GET['id_manufacturer'] = $id_manufacturer;
				$_GET['noredirect'] = 1;
			}
		}

		parent::init();
	}
}
