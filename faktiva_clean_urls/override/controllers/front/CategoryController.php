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

class CategoryController extends CategoryControllerCore
{
    public function init()
    {
      if ($category_rewrite = Tools::getValue('category_rewrite')) {
          
          $_base_url = str_replace(Tools::getHttpHost(true), '', $this->context->link->getPageLink('index',true));
          $uri = str_replace($_base_url, '', $_SERVER['REQUEST_URI']);
          $tree = explode("/", trim($uri,'/'));
		  //echo '<pre>Cat controller tree:'.print_r($tree,1).'</pre>';

		  $categories = Dispatcher::getSimpleCategories((int)Context::getContext()->language->id);
		  $id_category = 0;
		  foreach ($categories as $candidate){
				$cloneTree = $tree;
				if ($candidate['link_rewrite'] == array_pop($cloneTree)){
					if (empty($cloneTree) || $candidate['is_root_category'] ||  Dispatcher::checkParentsLoop($candidate, $categories, $cloneTree)){
						$id_category = (int)$candidate['id_category'];
						break;
					}
				}
			}

          if ($id_category > 0) {
              $_GET['id_category'] = $id_category;
          }
      }

      parent::init();
    }
}
