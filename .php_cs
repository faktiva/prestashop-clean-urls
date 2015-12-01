<?php

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->setCacheFile(__DIR__.'/.cache/php_cs.cache')
    ->setRules(array(
        '@PSR2' => true,
        'psr0' => false,
    ))
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;

// vim:ft=php
