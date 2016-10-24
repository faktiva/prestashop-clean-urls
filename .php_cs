<?php

$header = <<<EOF
This file is part of the "Prestashop Clean URLs" module.

(c) Faktiva (http://faktiva.com)

NOTICE OF LICENSE
This source file is subject to the CC BY-SA 4.0 license that is
available at the URL https://creativecommons.org/licenses/by-sa/4.0/

DISCLAIMER
This code is provided as is without any warranty.
No promise of being safe or secure

@author   Emiliano 'AlberT' Gabrielli <albert@faktiva.com>
@license  https://creativecommons.org/licenses/by-sa/4.0/  CC-BY-SA-4.0
@source   https://github.com/faktiva/prestashop-clean-urls
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

$finder = Symfony\CS\Finder::create()
    ->in(__DIR__.'/faktiva_clean_urls');

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(array(
        'header_comment',
        'empty_return',
        'long_array_syntax',
        'newline_after_open_tag',
        'short_echo_tag',
    ))
    ->finder($finder)
;

// vim:ft=php
