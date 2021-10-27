<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\DataProvider;

use Slub\SlubWebProfile\Utility\ConstantsUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TcaSelectItems
{
    /**
     * @param array $config
     */
    public function getDashboardCTypes(array &$config): void
    {
        $allowedCTypes = $this->getAllowedCTypes(
            $config,
            ConstantsUtility::EXTENSION_NAME . '_dashboard',
            'tt_content'
        );

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
     * @param string $contentElement
     * @param string $column
     * @return array
     */
    protected function getAllowedCTypes(
        array $config,
        string $contentElement,
        string $column
    ): array {
        $pageUid = $this->getPageUid($config);
        $pageTsConfig = BackendUtility::getPagesTSconfig($pageUid);

        return GeneralUtility::trimExplode(
            ',',
            $pageTsConfig['TCEFORM.']['tt_content.']['CType.']['types.'][$contentElement . '.'][$column . '.']['allowed']
        );
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
