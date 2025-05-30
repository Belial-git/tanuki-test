<?php

$config = new PhpCsFixer\Config();
$config->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');
$finder = PhpCsFixer\Finder::create()->exclude('vendor')->exclude('public')->exclude('storage')->in(__DIR__);
$config->setFinder($finder);
$config->setRiskyAllowed(true);
$config->setRules([
    '@Symfony' => true,
    'concat_space' => ['spacing' => 'one'],
    'global_namespace_import' => true,
    'array_syntax' => ['syntax' => 'short'],
    'linebreak_after_opening_tag' => true,
    'void_return' => true,
    'declare_strict_types' => true,
]);

return $config;
