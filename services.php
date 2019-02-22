<?php

return [
    'dom' => [
        'class' => \DOMDocument::class,
        'arguments' => [],
    ],
    'curl' => [
        'class' => \App\SharedKernel\Curl\Curl::class,
        'arguments' => [],
    ],
    'getHtmlPageContentService' => [
        'class' => \App\ParserContext\Infrastructure\Services\GetHtmlPageContentService::class,
        'arguments' => ['@curl'],
    ],
    'parseHtmlPageContentService' => [
        'class' => \App\ParserContext\Infrastructure\Services\ParseHtmlPageContentService::class,
        'arguments' => ['@dom'],
    ],
    'urlNormalizeService' => [
        'class' => \App\ParserContext\Infrastructure\Services\UrlNormalizeService::class,
        'arguments' => [],
    ],
    'parseCountImagesService' => [
        'class' => \App\ParserContext\Infrastructure\Services\GetDomainUrlsService::class,
        'arguments' => ['@getHtmlPageContentService', '@parseHtmlPageContentService', '@urlNormalizeService']
    ],
    'generateReportService' => [
        'class' => \App\ParserContext\Infrastructure\Services\GenerateReportService::class,
        'arguments' => [REPORTS_STORAGE_PATH, REPORT_TEMPLATE_PATH]
    ],
    'parseImages' => [
        'class' => \App\ParserContext\Application\Commands\ImagesCountReportCommand::class,
        'arguments' => ['@parseCountImagesService', '@generateReportService']
    ]
];