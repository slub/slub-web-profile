<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\DataProvider;

use Slub\SlubWebProfile\Service\WidgetService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class TcaSelectItems
{
    /**
     * @var WidgetService
     */
    protected $widgetService;

    public function __construct()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->widgetService = $objectManager->get(WidgetService::class);
    }

    /**
     * @param array $config
     */
    public function getDashboardCTypes(array &$config): void
    {
        $pageUid = $this->getPageUid($config);
        $allowedCTypes = $this->widgetService->getAllowedWidgets($pageUid);

        if (count($allowedCTypes) > 0) {
            /** @var array $item */
            foreach ($config['items'] as $key => $item) {
                if (in_array($item[1], $allowedCTypes, true) === false) {
                    unset($config['items'][$key]);
                }
            }
        }
    }

    /**
     * @param array $config
     * @return int
     */
    protected function getPageUid(array $config): int
    {
        return (int)$config['row']['pid'];
    }
}
