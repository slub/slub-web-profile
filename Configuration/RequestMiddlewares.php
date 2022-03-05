<?php

defined('TYPO3_MODE') || die();

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

return [
    'frontend' => [
        'slub/slub-web-profile/ajax-content-element' => [
            'target' => \Slub\SlubWebProfile\Middleware\AjaxContentElement::class,
            'before' => [
                'typo3/cms-frontend/output-compression',
            ],
            'after' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
        'slub/slub-web-profile/ajax-user-search-query' => [
            'target' => \Slub\SlubWebProfile\Middleware\AjaxUserSearchQuery::class,
            'before' => [
                'typo3/cms-frontend/content-length-header',
            ],
            'after' => [
                'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
            ],
        ],
        'slub/slub-web-profile/ajax-user-widget' => [
            'target' => \Slub\SlubWebProfile\Middleware\AjaxUserWidget::class,
            'before' => [
                'typo3/cms-frontend/content-length-header',
            ],
            'after' => [
                'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
            ],
        ],
    ],
];
