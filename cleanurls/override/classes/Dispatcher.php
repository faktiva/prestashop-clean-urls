<?php
class Dispatcher extends DispatcherCore
{
	/**
	 * @var array List of default routes
	 */
	public $default_routes = array(
		'supplier_rule' => array(
			'controller' =>	'supplier',
			'rule' =>		'supplier/{rewrite}/',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'supplier_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
			),
		),
		'smartblog_rule' => array(
			'controller' => 'category',
        		'rule' => 'blog/',
        		'keywords' => array(),
        	'params' => array(
        		'fc' => 'module',
        		'module' => 'smartblog',
        		),
        	),
		'manufacturer_rule' => array(
			'controller' =>	'manufacturer',
			'rule' =>		'manufacturer/{rewrite}/',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'manufacturer_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
			),
		),
		'cms_rule' => array(
			'controller' =>	'cms',
			'rule' =>		'info/{rewrite}',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'cms_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
			),
		),
		'cms_category_rule' => array(
			'controller' =>	'cms',
			'rule' =>		'info/{rewrite}/',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'cms_category_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
			),
		),
		'module' => array(
			'controller' =>	null,
			'rule' =>		'module/{module}{/:controller}',
			'keywords' => array(
				'module' =>			array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'module'),
				'controller' =>		array('regexp' => '[_a-zA-Z0-9_-]+', 'param' => 'controller'),
			),
			'params' => array(
				'fc' => 'module',
			),
		),
		'product_rule' => array(
			'controller' =>	'product',
			'rule' =>		'{category:/}{rewrite}.html',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'product_rewrite'),
				'ean13' =>			array('regexp' => '[0-9\pL]*'),
				'category' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'categories' =>		array('regexp' => '[/_a-zA-Z0-9-\pL]*'),
				'reference' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'manufacturer' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'supplier' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'price' =>			array('regexp' => '[0-9\.,]*'),
				'tags' =>			array('regexp' => '[a-zA-Z0-9-\pL]*'),
			),
		),
		'layered_rule' => array(
			'controller' =>	'category',
			'rule' =>		'{rewrite}/filter{selected_filters}',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				/* Selected filters is used by the module blocklayered */
				'selected_filters' =>		array('regexp' => '.*', 'param' => 'selected_filters'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'category_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
			),
		),
		'category_rule' => array(
			'controller' =>	'category',
			'rule' =>		'{parent_categories:/}{rewrite}/',
			'keywords' => array(
				'id' =>				array('regexp' => '[0-9]+'),
				'rewrite' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*', 'param' => 'category_rewrite'),
				'meta_keywords' =>	array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'meta_title' =>		array('regexp' => '[_a-zA-Z0-9-\pL]*'),
				'parent_categories' =>		array('regexp' => '[/_a-zA-Z0-9-\pL]*'),
				),
		),
	);
	
	/**
	 * Check if $short_link is a Product Link
	 *
	 * @param string $short_link: requested url without '?' part and without '/' on begining
	 * @return bool true: it's a link to product, false: it isn't
	 */
	public static function isProductLink($short_link)
	{
		// check if any keyword
		$explode_product_link = explode("/", $short_link);
		$count = count($explode_product_link);
		
		$sql = 'SELECT `id_product`
			FROM `'._DB_PREFIX_.'product_lang`
			WHERE `link_rewrite` = \''.$explode_product_link[$count-1].'\' AND `id_lang` = '. Context::getContext()->language->id;

		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
		}

		$id_product = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
			
		return ($id_product > 0) ? true : false;
	}
	
	/**
	 * Check if $short_link is a Category Link
	 *
	 * @param string $short_link: requested url without '?' part and without '/' on begining
	 * @return bool true: it's a link to category, false: it isn't
	 */
	public static function isCategoryLink($short_link)
	{
		// check if parent categories
		$categories = explode("/", $short_link);
		
		$sql = 'SELECT `id_category` FROM `'._DB_PREFIX_.'category_lang`
				WHERE `link_rewrite` = \''.$categories[0].'\' AND `id_lang` = '. Context::getContext()->language->id;

		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND `id_shop` = '.(int)Shop::getContextShopID();
		}
		
		$id_category = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
					
		return ($id_category > 0) ? true : false;
	}

	/**
	 * Check if $short_link is a Cms Link
	 *
	 * @param string $short_link: requested url without '?' part and without '/' on begining
	 * @return bool true: it's a link to cms page, false: it isn't
	 */
	public static function isCmsLink($short_link)
	{
		// check if any keyword
		$explode_cms_link = explode("/", $short_link);
		$count = count($explode_cms_link);
	
		$sql = 'SELECT l.`id_cms`
			FROM `'._DB_PREFIX_.'cms_lang` l
			LEFT JOIN `'._DB_PREFIX_.'cms_shop` s ON (l.`id_cms` = s.`id_cms`)
			WHERE l.`link_rewrite` = \''.$explode_cms_link[$count-1].'\'';

		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
		}

		$id_cms = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
					
		return ($id_cms > 0) ? true : false;
	}
	
	/**
	 * Check if $short_link is a Manufacturer Link
	 *
	 * @param string $short_link: requested url without '?' part and without '/' on begining
	 * @return bool true: it's a link to manufacturer, false: it isn't
	 */
	public static function isManufacturerLink($short_link)
	{
		// check if any keyword
		$explode_manufacturer_link = explode("/", $short_link);
		$count = count($explode_manufacturer_link);
		
		$name_manufacturer = str_replace('-', '%', $explode_manufacturer_link[$count-1]);

		$sql = 'SELECT m.`id_manufacturer`
			FROM `'._DB_PREFIX_.'manufacturer` m
			LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
			WHERE m.`name` LIKE \''.$name_manufacturer.'\'';
	
		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
		}

		$id_manufacturer = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
					
		return ($id_manufacturer > 0) ? true : false;
	}

	/**
	 * Check if $short_link is a Supplier Link
	 *
	 * @param string $short_link: requested url without '?' part and without '/' on begining
	 * @return bool true: it's a link to supplier, false: it isn't
	 */
	public static function isSupplierLink($short_link)
	{
		// check if any keyword
		$explode_supplier_link = explode("/", $short_link);
		$count = count($explode_supplier_link);
		
		$name_supplier = str_replace('-', '%', $explode_supplier_link[$count-1]);

		$sql = 'SELECT sp.`id_supplier`
			FROM `'._DB_PREFIX_.'supplier` sp
			LEFT JOIN `'._DB_PREFIX_.'supplier_shop` s ON (sp.`id_supplier` = s.`id_supplier`)
			WHERE sp.`name` LIKE \''.$name_supplier.'\'';

		if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
		{
			$sql .= ' AND s.`id_shop` = '.(int)Shop::getContextShopID();
		}

		$id_supplier = (int)Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);
					
		return ($id_supplier > 0) ? true : false;
	}

	/**
	 * Retrieve the controller from url or request uri if routes are activated
	 *
	 * @return string
	 */
	public function getController($id_shop = null)
	{	
		if (defined('_PS_ADMIN_DIR_'))
			$_GET['controllerUri'] = Tools::getvalue('controller');		
		if ($this->controller)
		{
			$_GET['controller'] = $this->controller;
			return $this->controller;
		}

		if ($id_shop === null)
			$id_shop = (int)Context::getContext()->shop->id;

		$controller = Tools::getValue('controller');
	
		if (isset($controller) && is_string($controller) && preg_match('/^([0-9a-z_-]+)\?(.*)=(.*)$/Ui', $controller, $m))
		{
			$controller = $m[1];
			if (isset($_GET['controller']))
				$_GET[$m[2]] = $m[3];
			else if (isset($_POST['controller']))
				$_POST[$m[2]] = $m[3];
		}

		if (!Validate::isControllerName($controller))
			$controller = false;
	
		// Use routes ? (for url rewriting)
		if ($this->use_routes && !$controller && !defined('_PS_ADMIN_DIR_'))
		{
			if (!$this->request_uri)
				return strtolower($this->controller_not_found);
			$controller = $this->controller_not_found;
			
			// If the request_uri matches a static file, then there is no need to check the routes, we keep "controller_not_found" (a static file should not go through the dispatcher) 
			if (!preg_match('/\.(gif|jpe?g|png|css|js|ico)$/i', $this->request_uri))
			{
				// Add empty route as last route to prevent this greedy regexp to match request uri before right time
				if ($this->empty_route)
					$this->addRoute($this->empty_route['routeID'], $this->empty_route['rule'], $this->empty_route['controller'], Context::getContext()->language->id, array(), array(), $id_shop);

				if (isset($this->routes[$id_shop][Context::getContext()->language->id]))
				{
//					$firephp = FirePHP::getInstance(true);
					$findRoute = array();
					
					// check, whether request_uri is template or not
					foreach ($this->routes[$id_shop][Context::getContext()->language->id] as $route)
					{
//						$firephp->log($route['rule'], 'Rule');
						
						if (preg_match($route['regexp'], $this->request_uri, $m))
						{
//							$firephp->log('RegExp Pass!');
							
							$isTemplate = false;
							
							switch($route['controller'])
							{
								case 'supplier':
								case 'manufacturer':
									// these two can be processed in normal way and also as template
									if(strpos($route['rule'], '{') !== false)
									{
										$isTemplate = true;
									}
									break;
									
								case 'cms':
								case 'product':
									$isTemplate = true;
									break;
								case 'category':
									// category can be processed in two ways
									if(strpos($route['rule'], 'selected_filters') === false)
									{
										$isTemplate = true;
									}
									break;
							}
							
//							$firephp->log((int)$isTemplate, 'Template');
							
							if($isTemplate == false)
							{
								$findRoute = $route;
								break;
							}
						}
					}
					
					// if route is not found, we have to find rewrite link in database
					if(empty($findRoute))
					{
						$req_url = substr($this->request_uri, 1); 		// remove '/' from begining
						$req_url = explode("?", $req_url);				// remove all after '?'
						$short_link = $req_url[0];
						
						// hack to make smartblog category path work. Remember to deactivate html in the smartblog module configuration
						if (null !== Configuration::get('smartmainblogurl')) {
							$blog_url = Configuration::get('smartmainblogurl');
						}
						else {
							// no smart blog we assume a generic blog path
							$blog_url = 'blog/'
						}
						
						if ($req_url[0] == $blog_url) {
							$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['smartblog_rule'];
						}
						
//						$firephp->log($short_link, 'Short Link');
						
						if(!Dispatcher::isProductLink($short_link))
							if(!Dispatcher::isCategoryLink($short_link))
								if(!Dispatcher::isCmsLink($short_link))
									if(!Dispatcher::isManufacturerLink($short_link))
										if(!Dispatcher::isSupplierLink($short_link))
											{}
										else
											$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['supplier_rule'];
									else
										$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['manufacturer_rule'];
								else
									$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['cms_rule'];
							else
								$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['category_rule'];
						else
							$findRoute = $this->routes[$id_shop][Context::getContext()->language->id]['product_rule'];
					}

					if(!empty($findRoute))
					{
//						$firephp->log($findRoute['rule'], 'Find Route Template');
						
						if (preg_match($findRoute['regexp'], $this->request_uri, $m))
						{
							// Route found ! Now fill $_GET with parameters of uri
							foreach ($m as $k => $v)
								if (!is_numeric($k))
									$_GET[$k] = $v;
		
							$controller = $findRoute['controller'] ? $findRoute['controller'] : $_GET['controller'];
							if (!empty($findRoute['params']))
								foreach ($findRoute['params'] as $k => $v)
									$_GET[$k] = $v;
		
							// A patch for module friendly urls
							if (preg_match('#module-([a-z0-9_-]+)-([a-z0-9]+)$#i', $controller, $m))
							{
								$_GET['module'] = $m[1];
								$_GET['fc'] = 'module';
								$controller = $m[2];
							}
		
							if (isset($_GET['fc']) && $_GET['fc'] == 'module')
								$this->front_controller = self::FC_MODULE;
						}
					}
				}
			}
			
			if ($controller == 'index' || $this->request_uri == '/index.php') 
				$controller = $this->default_controller;
			$this->controller = $controller;
		}
		// Default mode, take controller from url
		else
			$this->controller = $controller;

		$this->controller = str_replace('-', '', $this->controller);
		$_GET['controller'] = $this->controller;
		return $this->controller;
	}
}
