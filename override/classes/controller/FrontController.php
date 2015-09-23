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
