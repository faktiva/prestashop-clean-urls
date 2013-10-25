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
	 * Load default routes group by languages
	 */
	protected function loadRoutes($id_shop = null)
	{
		$context = Context::getContext();
		
		// Load custom routes from modules
		$modules_routes = Hook::exec('moduleRoutes', array('id_shop' => $id_shop), null, true, false);
		if (is_array($modules_routes) && count($modules_routes))
			foreach($modules_routes as $module_route)
				foreach($module_route as $route => $route_details)
					if (array_key_exists('controller', $route_details) && array_key_exists('rule', $route_details) 
						&& array_key_exists('keywords', $route_details) && array_key_exists('params', $route_details))
					{
						if (!isset($this->default_routes[$route]))
						$this->default_routes[$route] = array();
						$this->default_routes[$route] = array_merge($this->default_routes[$route], $route_details);
					}
		
		// Set default routes
		foreach (Language::getLanguages() as $lang)
			foreach ($this->default_routes as $id => $route)
				$this->addRoute(
					$id,
					$route['rule'],
					$route['controller'],
					$lang['id_lang'],
					$route['keywords'],
					isset($route['params']) ? $route['params'] : array(),
					$id_shop
				);
		
		// Load the custom routes prior the defaults to avoid infinite loops
		if ($this->use_routes)
		{
			// Get iso lang
			$iso_lang = Tools::getValue('isolang');
			$id_lang = $context->language->id;
			if (!empty($iso_lang))
				$id_lang = Language::getIdByIso($iso_lang);

			// Load routes from meta table
			$sql = 'SELECT m.page, ml.url_rewrite, ml.id_lang
					FROM `'._DB_PREFIX_.'meta` m
					LEFT JOIN `'._DB_PREFIX_.'meta_lang` ml ON (m.id_meta = ml.id_meta'.Shop::addSqlRestrictionOnLang('ml', $id_shop).')
					ORDER BY LENGTH(ml.url_rewrite) DESC';
			if ($results = Db::getInstance()->executeS($sql))
				foreach ($results as $row)
				{
					if ($row['url_rewrite'])
						$this->addRoute($row['page'], $row['url_rewrite'], $row['page'], $row['id_lang'], array(), array(), $id_shop);
				}

			// Set default empty route if no empty route (that's weird I know)
			if (!$this->empty_route)
				$this->empty_route = array(
					'routeID' =>	'index',
					'rule' =>		'',
					'controller' =>	'index',
				);

			// Load custom routes
			foreach ($this->default_routes as $route_id => $route_data)
				if ($custom_route = Configuration::get('PS_ROUTE_'.$route_id, null, null, $id_shop))
					foreach (Language::getLanguages() as $lang)
						$this->addRoute(
							$route_id,
							$custom_route,
							$route_data['controller'],
							$lang['id_lang'],
							$route_data['keywords'],
							isset($route_data['params']) ? $route_data['params'] : array(),
							$id_shop
						);
		}
	}
}