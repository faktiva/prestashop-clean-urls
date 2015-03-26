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
	public function __construct()
	{
		$this->name = 'cleanurls';
		$this->tab = 'seo';
		$this->version = '0.9';
		$this->author = 'ZiZuu Store';
		$this->need_instance = 1;
		$this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('ZiZuu Clean URLs');
		$this->description = $this->l('This override-Module allows you to remove URL ID\'s.');

		$this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	}

	public function getContent()
	{
		$output = '<p class="info">'
			.nl2br($this->l('On some versions you could have to disable Cache, '
				.'save, open your shop home page, than go back and enable it:
	
				Advanced Parameters > Performance > Clear Smarty cache
				Preferences -> SEO and URLs -> Set userfriendly URL off -> Save
				Preferences -> SEO and URLs -> Set userfriendly URL on -> Save'))
			.'</p>';

		$sql = 'SELECT * FROM `'._DB_PREFIX_.'product_lang`
			WHERE `link_rewrite`
			IN (SELECT `link_rewrite` FROM `'._DB_PREFIX_.'product_lang`
			GROUP BY `link_rewrite`, `id_lang`
			HAVING count(`link_rewrite`) > 1)';
		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
			$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();

		if ($res = Db::getInstance()->ExecuteS($sql))
		{
			$err = $this->l('You need to fix duplicate URL entries:').'<br />';
			foreach ($res as $row)
			{
				$lang = $this->context->language->getLanguage($row['id_lang']);
				$err .= $row['name'].' ('.$row['id_product'].') - '.$row['link_rewrite'].'<br />';

				$shop = $this->context->shop->getShop($lang['id_shop']);
				$err .= $this->l('Language: ').$lang['name'].'<br />'.$this->l('Shop: ').$shop['name'].'<br /><br />';
			}
			$output .= $this->displayError($err);
		}
		else
			$output .= $this->displayConfirmation($this->l('Nice. You have no duplicate URL entry.'));

		return '<div class="panel">'.$output.'</div>';
	}

	public function install()
	{
		// add link_rewrite as index to improve search
		$tables = array('category_lang','cms_category_lang','cms_lang','product_lang');
		foreach($tables as $tab)
		{
			if (!Db::getInstance()->ExecuteS('SHOW INDEX FROM `'._DB_PREFIX_.$tab.'` WHERE Key_name = \'link_rewrite\''))
				Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.$tab.'` ADD INDEX ( `link_rewrite` )');
		}

		if (!parent::install())
			return false;

		return true;
	}

	public function uninstall()
	{
		if (!parent::uninstall())
			return false;

		return true;
	}
}
