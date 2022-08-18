<?php

declare(strict_types=1);

$header = <<<'EOF'
This file is part of OpenSwoole RPC.
@link     https://openswoole.com
@contact  hello@openswoole.com
@license  https://github.com/openswoole/grpc/blob/main/LICENSE
EOF;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@DoctrineAnnotation'                    => true,
        '@PhpCsFixer'                            => true,
        '@PSR2'                                  => true,
        '@Symfony'                               => true,
        'align_multiline_comment'                => ['comment_type' => 'all_multiline'],
        'array_syntax'                           => ['syntax' => 'short'],
        'binary_operator_spaces'                 => ['operators' => ['=' => 'align', '=>' => 'align', ]],
        'blank_line_after_namespace'             => true,
        'blank_line_before_statement'            => ['statements' => ['declare']],
        'class_attributes_separation'            => true,
        'concat_space'                           => ['spacing' => 'one'],
        'constant_case'                          => ['case' => 'lower'],
        'combine_consecutive_unsets'             => true,
        'declare_strict_types'                   => true,
        'general_phpdoc_annotation_remove'       => ['annotations' => ['author']],
        'header_comment' => [
            'comment_type' => 'PHPDoc',
            'header' => $header,
            'separate' => 'none',
            'location' => 'after_declare_strict',
        ],
        'increment_style'                        => ['style' => 'post'],
        'lambda_not_used_import'                 => false,
        'linebreak_after_opening_tag'            => true,
        'list_syntax'                            => ['syntax' => 'short'],
        'lowercase_static_reference'             => true,
        'multiline_comment_opening_closing'      => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'new_line_for_chained_calls'],
        'no_unused_imports'                      => true,
        'no_useless_else'                        => true,
        'no_useless_return'                      => true,
        'not_operator_with_space'                => false,
        'not_operator_with_successor_space'      => false,
        'php_unit_strict'                        => false,
        'phpdoc_align'                           => ['align' => 'left'],
        'phpdoc_no_empty_return'                 => false,
        'phpdoc_types_order'                     => ['sort_algorithm' => 'none', 'null_adjustment' => 'always_last'],
        'phpdoc_separation'                      => false,
        'phpdoc_summary'                         => false,
        'ordered_class_elements'                 => true,
        'ordered_imports'                        => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        'single_line_comment_style'              => ['comment_types' => []],
        'single_quote'                           => true,
        'standardize_increment'                  => false,
        'standardize_not_equals'                 => true,
        'yoda_style'                             => ['always_move_variable' => false, 'equal' => false, 'identical' => false],
    ])
    ->setFinder(PhpCsFixer\Finder::create()->in([
        __DIR__ . '/src',
        __DIR__ . '/example'
    ]))
    ->setUsingCache(false);