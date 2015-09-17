<?php

class FrontController extends FrontControllerCore
{
    /**
     * Redirects to canonical URL
     *
     * Excludes "*_rewrite" URLs from being treated as non-canonical
     *
     * @param string $canonical_url
     */
    protected function canonicalRedirection($canonical_url = '')
    {
        /*
         * TODO: replace with a generic "*_rewrite" filter
         */
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
