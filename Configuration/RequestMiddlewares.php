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
        'slub/slub-web-profile/content-element' => [
            'target' => \Slub\SlubWebProfile\Middleware\ContentElement::class,
            'before' => [
                'typo3/cms-frontend/output-compression',
            ],
            'after' => [
                'typo3/cms-frontend/content-length-headers',
            ],
        ],
    ],
];
