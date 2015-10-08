<?php

return Symfony\CS\Config\Config::create()
    ->fixers(array('-psr0'))
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->setUsingCache(true)
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->exclude('vendor')
            ->in(__DIR__)
    )
;

// vim:ft=php
