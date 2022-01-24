<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Service;

use Slub\SlubWebProfile\Service\UserDashboardService as UserService;
use Slub\SlubWebProfile\Utility\ConstantsUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class WidgetService
{
    /**
     * @var ConnectionPool
     */
    protected $connectionPool;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param ConnectionPool $connectionPool
     */
    public function injectConnectionPool(ConnectionPool $connectionPool): void
    {
        $this->connectionPool = $connectionPool;
    }

    /**
     * @param UserService $userService
     */
    public function injectUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }

    /**
     * @return array
     * @throws \JsonException
     */
    public function getUserWidgets(): array
    {
        $widgets = $this->userService->getUserDashboard()['dashboardWidgets'] ?? [];

        return explode(',', $widgets);
    }

    /**
     * @param int $dashboardUid
     * @return array
     */
    public function findByDashboard(int $dashboardUid): array
    {
        $table = 'tt_content';
        $queryBuilder = $this->getQueryBuilder($table);

        return (array)$queryBuilder
            ->select('*')
            ->from($table)
            ->where(
                $queryBuilder->expr()->eq(
                    'irre_parent_uid',
                    $queryBuilder->createNamedParameter($dashboardUid, Connection::PARAM_INT)
                ),
                $queryBuilder->expr()->eq(
                    'irre_parent_table',
                    $queryBuilder->createNamedParameter('tt_content', Connection::PARAM_STR)
                )
            )
            ->orderBy('sorting', 'ASC')
            ->execute()
            ->fetchAll();
    }

    /**
     * @param array $widgets
     * @param array $validWidgets
     * @return array
     */
    public function validateWidgets(array $widgets, array $validWidgets): array
    {
        $validatedWidgets = [];

        foreach ($widgets as $widget) {
            if (in_array($widget, $validWidgets, true)) {
                $validatedWidgets[] = $widget;
            }
        }

        return array_unique($validatedWidgets);
    }

    /**
     * @param int $pageUid
     * @param string $contentElement
     * @param string $column
     * @return array
     */
    public function getAllowedWidgets(
        int $pageUid,
        string $contentElement = ConstantsUtility::EXTENSION_NAME . '_dashboard',
        string $column = 'tt_content'
    ): array {
        $pageTsConfig = BackendUtility::getPagesTSconfig($pageUid);

        return GeneralUtility::trimExplode(
            ',',
            $pageTsConfig['TCEFORM.']['tt_content.']['CType.']['types.'][$contentElement . '.'][$column . '.']['allowed']
        );
    }

    /**
     * @param string $table
     * @return QueryBuilder
     */
    protected function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
