<?php

use Marvin\SearchSuggest\Controller\FcSuggestionsController;

$sMetadataVersion = '2.1';

$aModule = [
    'id'          => 'marvin-search-suggest',
    'title'       => 'Search Suggest',
    'description' => 'Provides search suggestions for your OXID E-Shop',
    'thumbnail'   => 'search-suggest.png',
    'version'     => '1.0.0',
    'author'      => 'Marvin Pöhls',
    'url'         => 'https://www.fatchip.de/',
    'email'       => 'support@fatchip.de',
    'controllers' => [
        'fcGetSuggestions' => FcSuggestionsController::class,
    ],
    'extend'      => [
        \OxidEsales\Eshop\Application\Model\Article::class => \Marvin\SearchSuggest\Model\Article::class
    ],
    'settings'    => [],
    'events'      => [],
    'blocks' => [
        [
            'template' => 'widget/header/search.tpl',
            'block' => 'dd_widget_header_search_form_inner',
            'file' => 'views/blocks/widget/header/search_suggestions_dd_widget_header_search_form_inner.tpl',
        ],
        [
            'template' => 'widget/header/search.tpl',
            'block' => 'header_search_field',
            'file' => 'views/blocks/widget/header/header_search_field.tpl',
        ],
    ]
];
