<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'vendor',
    ])
;

$config = new PhpCsFixer\Config();
return $config->setRules([
        'declare_strict_types' => true,
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property',
                'construct',
                'destruct',
                'magic',
                'phpunit',
                'method_public',
                'method_protected',
                'method_private',
            ],
        ],
        'ordered_imports' => true,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
