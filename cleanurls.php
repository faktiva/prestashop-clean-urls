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
 *  @author      ZiZuu.com <info@zizuu.com>
 *  @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  @source      https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs
 */

if (!defined('_PS_VERSION_'))
	exit;

class CleanUrls extends Module
{
	const _MODULE_NAME = 'cleanurls';

	public function __construct()
	{
		$this->name = self::_MODULE_NAME;
		$this->tab = 'seo';
		$this->version = '0.8';
		$this->author = 'ZiZuu Store';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('ZiZuu Clean URLs');
		$this->description = $this->l('This override-Module allows you to remove URL ID\'s.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall "'.self::_MODULE_NAME.'"?');
	}

	public function getContent()
	{
		$output = '<p>
				On some versions you have to disable Cache save than open your shop home page than go back and enable it.<br />
				Advanced Parameters > Performance > Clear Smarty cache<br /><br />
				Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL off -> Save<br />
				Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL on -> Save<br />
				</p>';

		$sql = 'SELECT * FROM `'._DB_PREFIX_.'product_lang`
			WHERE `link_rewrite`
			IN (SELECT `link_rewrite` FROM `'._DB_PREFIX_.'product_lang`
			GROUP BY `link_rewrite`, `id_lang`
			HAVING count(`link_rewrite`) > 1)';
		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();

		if ($results = Db::getInstance()->ExecuteS($sql))
		{
			$this->adminDisplayWarning('You need to fix duplicate URL entries.');
			foreach ($results as $row)
			{
				$language_info = $this->context->language->getLanguage($row['id_lang']);
				$output .= $row['name'].' ('.$row['id_product'] .') - '. $row['link_rewrite'].'<br />';
				$shop_info = $this->context->shop->getShop($language_info['id_shop']);
				$output .= 'Language:'. $language_info['name'] . '<br /> Shop:' . $shop_info['name'].'<br /><br />';
			}
		}
		else
			$output .= '<strong>Nice you don\'t have any duplicate URL entries.</strong>';

		return $output;
	}

	public function install()
	{
		// add link_rewrite as index to improve search
		$table_list = array('category_lang','cms_category_lang','cms_lang','product_lang');
		foreach($table_list as $table)
		{
			if (!Db::getInstance()->ExecuteS('SHOW INDEX FROM `'._DB_PREFIX_.$table.'` WHERE Key_name = \'link_rewrite\''))
				Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.$table.'` ADD INDEX ( `link_rewrite` )');
		}

		return parent::install();
	}

	public function uninstall()
	{
		return parent::uninstall();
	}
}
