<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\DataProcessing\MenuProcessor;

class MenuUtility
{
    /**
     * @param ContentObjectRenderer $cObject
     * @param string $field
     * @return array
     */
    public static function getList(
        ContentObjectRenderer $cObject,
        string $field = 'pages'
    ): array {
        /** @var MenuProcessor $menuProcessor */
        $menuProcessor = GeneralUtility::makeInstance(MenuProcessor::class);

        return $menuProcessor->process(
            $cObject,
            [],
            [
                'special' => 'list',
                'special.' => [
                    'value.' => [
                        'field' => $field
                    ]
                ]
            ],
            []
        );
    }
}
