<?php

/*
 * This file is part of the "Prestashop Clean URLs" module.
 *
 * (c) Faktiva (http://faktiva.com)
 *
 * NOTICE OF LICENSE
 * This source file is subject to the CC BY-SA 4.0 license that is
 * available at the URL https://creativecommons.org/licenses/by-sa/4.0/
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
 * @license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
 * @source   https://github.com/faktiva/prestashop-clean-urls
 */

class Dispatcher extends DispatcherCore
{
    /**
     * Load default routes group by languages.
     */
    protected function loadRoutes($id_shop = null)
    {
        /*
         * @var array List of default routes
         */
        $this->default_routes = array(
            'category_rule' => array(
                'controller' => 'category',
                'rule' => '{rewrite}/',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'categories' => array('regexp' => '[/_a-zA-Z0-9\pL\pS-]*'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'category_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
            'supplier_rule' => array(
                'controller' => 'supplier',
                'rule' => 'supplier/{rewrite}',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'supplier_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
            'manufacturer_rule' => array(
                'controller' => 'manufacturer',
                'rule' => 'manufacturer/{rewrite}',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'manufacturer_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
            'cms_rule' => array(
                'controller' => 'cms',
                'rule' => 'info/{rewrite}',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'cms_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
            'cms_category_rule' => array(
                'controller' => 'cms',
                'rule' => 'info/{rewrite}/',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'cms_category_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
            'module' => array(
                'controller' => null,
                'rule' => 'module/{module}/{controller}',
                'keywords' => array(
                    'module' => array('regexp' => '[_a-zA-Z0-9-]+', 'param' => 'module'),
                    'controller' => array('regexp' => '[_a-zA-Z0-9-]+', 'param' => 'controller'),
                ),
                'params' => array(
                    'fc' => 'module',
                ),
            ),
            'product_rule' => array(
                'controller' => 'product',
                'rule' => '{category:/}{rewrite}',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL\pS-]*', 'param' => 'product_rewrite'),
                    'ean13' => array('regexp' => '[0-9]{8,17}'),
                    'category' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'categories' => array('regexp' => '[/_a-zA-Z0-9\pL-]*'),
                    'reference' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'manufacturer' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'supplier' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'price' => array('regexp' => '[0-9\.,]*'),
                    'tags' => array('regexp' => '[a-zA-Z0-9\pL-]*'),
                ),
            ),
            'layered_rule' => array(
                'controller' => 'category',
                'rule' => '{rewrite}/f/{selected_filters}',
                'keywords' => array(
                    'id' => array('regexp' => '[0-9]+'),
                    'selected_filters' => array('regexp' => '.*', 'param' => 'selected_filters'),
                    'rewrite' => array('regexp' => '[_a-zA-Z0-9\pL-]*', 'param' => 'category_rewrite'),
                    'meta_keywords' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                    'meta_title' => array('regexp' => '[_a-zA-Z0-9\pL-]*'),
                ),
            ),
        );

        parent::loadRoutes($id_shop);
    }

    /**
     * @param string $route_id   Name of the route (need to be uniq, a second route with same name will override the first)
     * @param string $rule       Url rule
     * @param string $controller Controller to call if request uri match the rule
     * @param int    $id_lang
     * @param int    $id_shop
     */
    public function addRoute($route_id, $rule, $controller, $id_lang = null, array $keywords = array(), array $params = array(), $id_shop = null)
    {
        if (isset(Context::getContext()->language) && $id_lang === null) {
            $id_lang = (int) Context::getContext()->language->id;
        }

        if (isset(Context::getContext()->shop) && $id_shop === null) {
            $id_shop = (int) Context::getContext()->shop->id;
        }

        $regexp = preg_quote($rule, '#');
        if ($keywords) {
            $transform_keywords = array();
            preg_match_all('#\\\{(([^{}]*)\\\:)?('.implode('|', array_keys($keywords)).')(\\\:([^{}]*))?\\\}#', $regexp, $m);
            for ($i = 0, $total = count($m[0]); $i < $total; ++$i) {
                $prepend = $m[2][$i];
                $keyword = $m[3][$i];
                $append = $m[5][$i];
                $transform_keywords[$keyword] = array(
                    'required' => isset($keywords[$keyword]['param']),
                    'prepend' => stripslashes($prepend),
                    'append' => stripslashes($append),
                );

                $prepend_regexp = $append_regexp = '';
                if ($prepend || $append) {
                    $prepend_regexp = '('.$prepend;
                    $append_regexp = $append.')??'; // fix greediness (step 1)
                }

                if (isset($keywords[$keyword]['param'])) {
                    $regexp = str_replace($m[0][$i], $prepend_regexp.'(?P<'.$keywords[$keyword]['param'].'>'.$keywords[$keyword]['regexp'].')'.$append_regexp, $regexp);
                } else {
                    $regexp = str_replace($m[0][$i], $prepend_regexp.'('.$keywords[$keyword]['regexp'].')'.$append_regexp, $regexp);
                }
            }
            $keywords = $transform_keywords;
        }

        $regexp = '#^/'.$regexp.'$#uU'; // fix greediness (step 2)
        if (!isset($this->routes[$id_shop])) {
            $this->routes[$id_shop] = array();
        }
        if (!isset($this->routes[$id_shop][$id_lang])) {
            $this->routes[$id_shop][$id_lang] = array();
        }

        $this->routes[$id_shop][$id_lang][$route_id] = array(
            'rule' => $rule,
            'regexp' => $regexp,
            'controller' => $controller,
            'keywords' => $keywords,
            'params' => $params,
        );
    }

    /**
     * Retrieve the controller from url or request uri if routes are activated.
     *
     * @param int $id_shop, defaults null
     *
     * @return string
     */
    public function getController($id_shop = null)
    {
        if (defined('_PS_ADMIN_DIR_')) {
            $_GET['controllerUri'] = Tools::getvalue('controller');
        }

        if ($this->controller) {
            $_GET['controller'] = $this->controller;

            return $this->controller;
        }

        if (null === $id_shop) {
            $id_shop = (int) Context::getContext()->shop->id;
        }

        $controller = Tools::getValue('controller');

        $curr_lang_id = Context::getContext()->language->id;

        if (isset($controller) && is_string($controller) && preg_match('/^([0-9a-z_-]+)\?(.*)=(.*)$/Ui', $controller, $m)) {
            $controller = $m[1];
            if (isset($_GET['controller'])) {
                $_GET[$m[2]] = $m[3];
            } elseif (isset($_POST['controller'])) {
                $_POST[$m[2]] = $m[3];
            }
        }

        if (!Validate::isControllerName($controller)) {
            $controller = false;
        }

        // Use routes ? (for url rewriting)
        if ($this->use_routes && !$controller && !defined('_PS_ADMIN_DIR_')) {
            if (!$this->request_uri) {
                return strtolower($this->controller_not_found);
            }
            $controller = $this->controller_not_found;

            // If the request_uri matches a static file, then there is no need to check the routes, we keep "controller_not_found" (a static file should not go through the dispatcher)
            if (!preg_match('/\.(gif|jpe?g|png|css|js|ico)$/i', $this->request_uri)) {
                // Add empty route as last route to prevent this greedy regexp to match request uri before right time
                if ($this->empty_route) {
                    $this->addRoute($this->empty_route['routeID'], $this->empty_route['rule'], $this->empty_route['controller'], $curr_lang_id, array(), array(), $id_shop);
                }

                list($uri) = explode('?', $this->request_uri);

                if (isset($this->routes[$id_shop][$curr_lang_id])) {
                    $route = array();

                    // check, whether request_uri is template or not
                    foreach ($this->routes[$id_shop][$curr_lang_id] as $k => $r) {
                        if (preg_match($r['regexp'], $uri, $m)) {
                            $isTemplate = false;
                            $module = isset($r['params']['module']) ? $r['params']['module'] : '';
                            switch ($r['controller'].$module) { // Avoid name collision between core and modules' controllers
                                case 'supplier':
                                case 'manufacturer':
                                    // these two can be processed in normal way and also as template
                                    if (false !== strpos($r['rule'], '{')) {
                                        $isTemplate = true;
                                    }
                                    break;

                                case 'cms':
                                case 'product':
                                    $isTemplate = true;
                                    break;
                                case 'category':
                                    // category can be processed in two ways
                                    if (false === strpos($r['rule'], 'selected_filters')) {
                                        $isTemplate = true;
                                    }
                                    break;
                            }

                            if (!$isTemplate) {
                                $route = $r;
                                break;
                            }
                        }
                    }

                    // if route is not found, we have to find rewrite link in database
                    if (empty($route)) {
                        // get the path from requested URI, and remove "/" at the beginning
                        $short_link = ltrim(parse_url($uri, PHP_URL_PATH), '/');

                        $route = $this->routes[$id_shop][$curr_lang_id]['product_rule'];
                        if (!self::isProductLink($short_link, $route)) {
                            $route = $this->routes[$id_shop][$curr_lang_id]['category_rule'];
                            if (!self::isCategoryLink($short_link, $route)) {
                                $route = $this->routes[$id_shop][$curr_lang_id]['cms_rule'];
                                if (!self::isCmsLink($short_link, $route)) {
                                    $route = $this->routes[$id_shop][$curr_lang_id]['cms_category_rule'];
                                    if (!self::isCmsCategoryLink($short_link, $route)) {
                                        $route = $this->routes[$id_shop][$curr_lang_id]['manufacturer_rule'];
                                        if (!self::isManufacturerLink($short_link, $route)) {
                                            $route = $this->routes[$id_shop][$curr_lang_id]['supplier_rule'];
                                            if (!self::isSupplierLink($short_link, $route)) {
                                                // no route found
                                                $route = array();
                                                $controller = $this->controller_not_found;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if (!empty($route['controller'])) {
                            $controller = $route['controller'];
                        }
                    }

                    if (!empty($route)) {
                        if (preg_match($route['regexp'], $uri, $m)) {
                            // Route found! Now fill $_GET with parameters of uri
                            foreach ($m as $k => $v) {
                                if (!is_numeric($k)) {
                                    $_GET[$k] = $v;
                                }
                            }

                            $controller = $route['controller'] ? $route['controller'] : $_GET['controller'];
                            if (!empty($route['params'])) {
                                foreach ($route['params'] as $k => $v) {
                                    $_GET[$k] = $v;
                                }
                            }

                            // A patch for module friendly urls
                            if (preg_match('#module-([a-z0-9_-]+)-([a-z0-9]+)$#i', $controller, $m)) {
                                $_GET['module'] = $m[1];
                                $_GET['fc'] = 'module';
                                $controller = $m[2];
                            }

                            if (isset($_GET['fc']) && $_GET['fc'] == 'module') {
                                $this->front_controller = self::FC_MODULE;
                            }
                        }
                    }
                }
            }

            if ($controller == 'index' || $this->request_uri == '/index.php') {
                $controller = $this->default_controller;
            }
            $this->controller = $controller;
        } else { // Default mode, take controller from url
            $this->controller = $controller;
        }

        $this->controller = str_replace('-', '', $this->controller);
        $_GET['controller'] = $this->controller;

        return $this->controller;
    }

    /**
     * Check if $short_link is a Product Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to product, false: it isn't
     */
    private static function isProductLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['product_rewrite'])) {
            return false;
        }

        $sql = 'SELECT `id_product`
            FROM `'._DB_PREFIX_.'product_lang`
            WHERE `link_rewrite` = \''.pSQL($kw['product_rewrite']).'\' AND `id_lang` = '.(int) Context::getContext()->language->id;
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND `id_shop` = '.(int) Shop::getContextShopID();
        }
        $id_product = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_product > 0;
    }

    /**
     * Check if $short_link is a Category Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to category, false: it isn't
     */
    private static function isCategoryLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['category_rewrite'])) {
            return false;
        }

        $sql = 'SELECT `id_category`
            FROM `'._DB_PREFIX_.'category_lang`
            WHERE `link_rewrite` = \''.pSQL($kw['category_rewrite']).'\' AND `id_lang` = '.(int) Context::getContext()->language->id;
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND `id_shop` = '.(int) Shop::getContextShopID();
        }

        $id_category = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_category > 0;
    }

    /**
     * Check if $short_link is a Cms Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to cms page, false: it isn't
     */
    private static function isCmsLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['cms_rewrite'])) {
            return false;
        }

        $sql = 'SELECT l.`id_cms`
            FROM `'._DB_PREFIX_.'cms_lang` l
            LEFT JOIN `'._DB_PREFIX_.'cms_shop` s ON (l.`id_cms` = s.`id_cms`)
            WHERE l.`link_rewrite` = \''.pSQL($kw['cms_rewrite']).'\'';
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
        }

        $id_cms = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_cms > 0;
    }

    /**
     * Check if $short_link is a Cms Category Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to cms page, false: it isn't
     */
    private static function isCmsCategoryLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['cms_category_rewrite'])) {
            if (0 === strpos('/'.$route['rule'], $short_link)) {
                //no link_rewrite, but uri starts with the link -> cms categories' list
                return true;
            }

            return false;
        }

        $sql = 'SELECT l.`id_cms_category`
            FROM `'._DB_PREFIX_.'cms_category_lang` l
            LEFT JOIN `'._DB_PREFIX_.'cms_category_shop` s ON (l.`id_cms_category` = s.`id_cms_category`)
            WHERE l.`link_rewrite` = \''.$kw['cms_category_rewrite'].'\'';
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
        }

        $id_cms_cat = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_cms_cat > 0;
    }

    /**
     * Check if $short_link is a Manufacturer Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to manufacturer, false: it isn't
     */
    private static function isManufacturerLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['manufacturer_rewrite'])) {
            if (0 === strpos('/'.$route['rule'], $short_link)) {
                //no link_rewrite, but uri starts with the link -> manufactures' list
                return true;
            }

            return false;
        }

        $manufacturer = str_replace('-', '_', $kw['manufacturer_rewrite']);

        $sql = 'SELECT m.`id_manufacturer`
            FROM `'._DB_PREFIX_.'manufacturer` m
            LEFT JOIN `'._DB_PREFIX_.'manufacturer_shop` s ON (m.`id_manufacturer` = s.`id_manufacturer`)
            WHERE LOWER(m.`name`) LIKE \''.pSQL($manufacturer).'\'';
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
        }

        $id_manufacturer = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_manufacturer > 0;
    }

    /**
     * Check if $short_link is a Supplier Link.
     *
     * @param string $short_link: requested url without '?' part and without '/' on begining
     *
     * @return bool true: it's a link to supplier, false: it isn't
     */
    private static function isSupplierLink($short_link, $route)
    {
        $short_link = preg_replace('#\.html?$#', '', '/'.$short_link);
        $regexp = preg_replace('!\\\.html?\\$#!', '$#', $route['regexp']);

        preg_match($regexp, $short_link, $kw);
        if (empty($kw['supplier_rewrite'])) {
            if (0 === strpos('/'.$route['rule'], $short_link)) {
                //no link_rewrite, but uri starts with the link -> suppliers' list
                return true;
            }

            return false;
        }

        $supplier = str_replace('-', '_', $kw['supplier_rewrite']);

        $sql = 'SELECT sp.`id_supplier`
            FROM `'._DB_PREFIX_.'supplier` sp
            LEFT JOIN `'._DB_PREFIX_.'supplier_shop` s ON (sp.`id_supplier` = s.`id_supplier`)
            WHERE LOWER(sp.`name`) LIKE \''.pSQL($supplier).'\'';
        if (Shop::isFeatureActive() && Shop::getContext() == Shop::CONTEXT_SHOP) {
            $sql .= ' AND s.`id_shop` = '.(int) Shop::getContextShopID();
        }

        $id_supplier = (int) Db::getInstance(_PS_USE_SQL_SLAVE_)->getValue($sql);

        return $id_supplier > 0;
    }
}
