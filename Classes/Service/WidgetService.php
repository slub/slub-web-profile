<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Service;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

class WidgetService
{
    /**
     * @var ConnectionPool
     */
    protected $connectionPool;

    /**
     * @param ConnectionPool $connectionPool
     */
    public function injectConnectionPool(ConnectionPool $connectionPool): void
    {
        $this->connectionPool = $connectionPool;
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
     * @param string $table
     * @return QueryBuilder
     */
    protected function getQueryBuilder(string $table): QueryBuilder
    {
        return $this->connectionPool->getQueryBuilderForTable($table);
    }
}
