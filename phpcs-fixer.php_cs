<?php

// extend the default coding-standards
$config = require __DIR__ . '/vendor/shopsys/coding-standards/build/phpcs-fixer.php_cs';
/* @var $config \PhpCsFixer\Config */
$config
    ->setRules(array_merge(
        $config->getRules(),
        [
            'declare_strict_types' => true,
        ]
    ));

return $config;
