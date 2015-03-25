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

class FrontController extends FrontControllerCore
{

	public function __construct()
	{
		parent::__construct();
	}

	protected function canonicalRedirection($canonical_url = '')
	{
		$excluded_keys = array(
			'product_rewrite',
			'category_rewrite',
			'manufacturer_rewrite',
			'supplier_rewrite',
			'cms_rewrite',
			'cms_category_rewrite',
		);

		// hack original behavior on cananocalRedirection: remove *_rewrite from _GET
		$unfiltered_GET = $_GET;
		$_GET = array_diff_key($_GET, array_flip($excluded_keys));
		parent::canonicalRedirection($canonical_url);
		$_GET = $unfiltered_GET;
	}				       
}
