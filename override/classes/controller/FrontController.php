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

class FrontController extends FrontControllerCore
{
    /**
     * Redirects to canonical URL.
     *
     * Excludes "*_rewrite" URLs from being treated as non-canonical
     *
     * @param string $canonical_url
     */
    protected function canonicalRedirection($canonical_url = '')
    {
        $_unfiltered_GET = $_GET;

        // hack original behavior on cananocalRedirection: remove *_rewrite from _GET
        $_GET = array_filter($_GET, function ($v) {
            return '_rewrite' === substr($v, -8);
        });

        parent::canonicalRedirection($canonical_url);

        //restore original _GET
        $_GET = $_unfiltered_GET;
    }
}
