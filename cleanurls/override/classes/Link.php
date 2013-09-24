<?php

class Link extends LinkCore
{
	/**
	 * Create a link to a category
	 *
	 * @param mixed $category Category object (can be an ID category, but deprecated)
	 * @param string $alias
	 * @param int $id_lang
	 * @param string $selected_filters Url parameter to autocheck filters of the module blocklayered
	 * @return string
	 */
	public function getCategoryLink($category, $alias = null, $id_lang = null, $selected_filters = null, $id_shop = null)
	{
		if (!$id_lang)
			$id_lang = Context::getContext()->language->id;
		
		if ($id_shop === null)
			$shop = Context::getContext()->shop;
		else
			$shop = new Shop($id_shop);
		$url = 'http://'.$shop->domain.$shop->getBaseURI().$this->getLangLink($id_lang, null, $id_shop);

		if (!is_object($category))
			$category = new Category($category, $id_lang);

		// Set available keywords
		$params = array();
		$params['id'] = $category->id;
		$params['rewrite'] = (!$alias) ? $category->link_rewrite : $alias;
		$params['meta_keywords'] =	Tools::str2url($category->meta_keywords);
		$params['meta_title'] = Tools::str2url($category->meta_title);

		// Selected filters is used by the module blocklayered
		$selected_filters = is_null($selected_filters) ? '' : $selected_filters;

		if (empty($selected_filters))
			$rule = 'category_rule';
		else
		{
			$rule = 'layered_rule';
			$params['selected_filters'] = $selected_filters;
		}

			//$params['category'] = $category->link_rewrite;
			$cats = array();
			$subCategories = $this->_getParentsCategories($category->id);
			$subCategories = is_array($subCategories) === TRUE ? array_reverse($subCategories) : $subCategories;
			$skip_list = Link::$category_disable_rewrite;
			$skip_list[] = $category->id;
			foreach ($subCategories as $cat)
			{
				if (!in_array($cat['id_category'], $skip_list))//remove root and home category from the URL
					$cats[] = $cat['link_rewrite'];
			}
			$params['categories'] = implode('/', $cats);
		

		return $url.Dispatcher::getInstance()->createUrl($rule, $id_lang, $params, $this->allow);
	}

	/**
	 * Get Each parent category of this category until the root category
	 *
	 * @param integer $id_lang Language ID
	 * @return array Corresponding categories
	 */
	public function _getParentsCategories($id_current = NULL)
	{
		$context = Context::getContext()->cloneContext();
		$context->shop = clone($context->shop);

		$id_lang = $context->language->id;

		$categories = null;

		if (count(Category::getCategoriesWithoutParent()) > 1 && Configuration::get('PS_MULTISHOP_FEATURE_ACTIVE') && count(Shop::getShops(true, null, true)) != 1)
			$context->shop->id_category = Category::getTopCategory()->id;
		elseif (!$context->shop->id)
			$context->shop = new Shop(Configuration::get('PS_SHOP_DEFAULT'));
		$id_shop = $context->shop->id;
		while (true)
		{
			$sql = '
			SELECT c.*, cl.*
			FROM `'._DB_PREFIX_.'category` c
			LEFT JOIN `'._DB_PREFIX_.'category_lang` cl
				ON (c.`id_category` = cl.`id_category`
				AND `id_lang` = '.(int)$id_lang.Shop::addSqlRestrictionOnLang('cl').')';
			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= '
			LEFT JOIN `'._DB_PREFIX_.'category_shop` cs
				ON (c.`id_category` = cs.`id_category` AND cs.`id_shop` = '.(int)$id_shop.')';
			$sql .= '
			WHERE c.`id_category` = '.(int)$id_current;
			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP)
				$sql .= '
				AND cs.`id_shop` = '.(int)$context->shop->id;
			$root_category = Category::getRootCategory();
			if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP &&
				(!Tools::isSubmit('id_category') ||
					(int)Tools::getValue('id_category') == (int)$root_category->id ||
					(int)$root_category->id == (int)$context->shop->id_category))
				$sql .= '
					AND c.`id_parent` != 0';

			$result = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

			if (isset($result[0]))
				$categories[] = $result[0];
			else if (!$categories)
				$categories = array();
			if (!$result || ($result[0]['id_category'] == $context->shop->id_category))
				return $categories;
			$id_current = $result[0]['id_parent'];
		}
	}

	/**
	 * Get pagination link
	 *
	 * @param string $type Controller name
	 * @param int $id_object
	 * @param boolean $nb Show nb element per page attribute
	 * @param boolean $sort Show sort attribute
	 * @param boolean $pagination Show page number attribute
	 * @param boolean $array If false return an url, if true return an array
	 */
	public function getPaginationLink($type, $id_object, $nb = false, $sort = false, $pagination = false, $array = false)
	{
		// If no parameter $type, try to get it by using the controller name
		if (!$type && !$id_object)
		{
			$method_name = 'get'.Dispatcher::getInstance()->getController().'Link';
			if (method_exists($this, $method_name) && isset($_GET['id_'.Dispatcher::getInstance()->getController()]))
			{
				$type = Dispatcher::getInstance()->getController();
				$id_object = $_GET['id_'.$type];
			}
		}

		if ($type && $id_object)
			$url = $this->{'get'.$type.'Link'}($id_object, null);
		else
		{
			if (isset(Context::getContext()->controller->php_self))
				$name = Context::getContext()->controller->php_self;
			else
				$name = Dispatcher::getInstance()->getController();
			$url = $this->getPageLink($name);
		}

		$vars = array();
		$vars_nb = array('n', 'search_query');
		$vars_sort = array('orderby', 'orderway');
		$vars_pagination = array('p');

		foreach ($_GET as $k => $value)
		{
			// Ha!*!*y strip var like category_rewrite from url
			if ($k != 'id_'.$type && $k != $type.'_rewrite' && $k != 'controller')
			{
				if (Configuration::get('PS_REWRITING_SETTINGS') && ($k == 'isolang' || $k == 'id_lang'))
					continue;
				$if_nb = (!$nb || ($nb && !in_array($k, $vars_nb)));
				$if_sort = (!$sort || ($sort && !in_array($k, $vars_sort)));
				$if_pagination = (!$pagination || ($pagination && !in_array($k, $vars_pagination)));
				if ($if_nb && $if_sort && $if_pagination)
				{
					if (!is_array($value))
						$vars[urlencode($k)] = $value;
					else
					{
						foreach (explode('&', http_build_query(array($k => $value), '', '&')) as $key => $val)
						{
							$data = explode('=', $val);
							$vars[urldecode($data[0])] = $data[1];
						}
					}
				}
			}
		}

		if (!$array)
			if (count($vars))
				return $url.(($this->allow == 1 || $url == $this->url) ? '?' : '&').http_build_query($vars, '', '&');
			else
				return $url;
		
		$vars['requestUrl'] = $url;

		if ($type && $id_object)
			$vars['id_'.$type] = (is_object($id_object) ? (int)$id_object->id : (int)$id_object);
			
		if (!$this->allow == 1)
			$vars['controller'] = Dispatcher::getInstance()->getController();
		return $vars;
	}

}
