<?php

/*
 * This file is part of the zzCleanURLs module.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 * DISCLAIMER
 * This code is provided as is without any warranty.
 * No promise of being safe or secure
 *
 * @author   ZiZuu.com <info@zizuu.com>
 * @source   https://github.com/ZiZuu-store/zzCleanURLs
 */

class FrontController extends FrontControllerCore
{
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

        $unfiltered_GET = $_GET;
        $_GET = array_diff_key($_GET, array_flip($excluded_keys)); // hack original behavior on cananocalRedirection: remove *_rewrite from _GET
        parent::canonicalRedirection($canonical_url);
        $_GET = $unfiltered_GET;                                   //restore original _GET
    }
}
