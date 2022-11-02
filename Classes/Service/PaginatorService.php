<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Service;

class PaginatorService
{
    /**
     * @param array $paginator
     * @return array
     */
    public function getPaginator(array $paginator): array
    {
        $currentPage = $paginator['currentPage'];
        $itemsPerPage = $paginator['itemsPerPage'];
        $maximumLinks = $paginator['countItems'];

        $pages = $this->getNumberOfPages($maximumLinks, $itemsPerPage);
        $previousPageNumber = $this->getPreviousPageNumber($currentPage, $pages);
        $firstPageNumber = $this->getFirstPageNumber();
        $nextPageNumber = $this->getNextPageNumber($currentPage, $maximumLinks, $itemsPerPage);
        $lastPageNumber = $this->getLastPageNumber($maximumLinks, $itemsPerPage);
        $allPageNumbers = $this->getAllPageNumbers($maximumLinks, $itemsPerPage);

        return [
            'currentPage' => $currentPage,
            'pages' => $pages,
            'previousPageNumber' => $previousPageNumber,
            'firstPageNumber' => $firstPageNumber,
            'nextPageNumber' => $nextPageNumber,
            'lastPageNumber' => $lastPageNumber,
            'allPageNumbers' => $allPageNumbers
        ];
    }

    /**
     * @param int $maximumLinks
     * @param int $itemsPerPage
     * @return int
     */
    protected function getNumberOfPages(int $maximumLinks, int $itemsPerPage): int
    {
        return (int)ceil($maximumLinks / $itemsPerPage);
    }

    /**
     * @param int $currentPage
     * @param int $pages
     * @return int|null
     */
    protected function getPreviousPageNumber(int $currentPage, int $pages): ?int
    {
        $previousPage = $currentPage - 1;

        if ($previousPage > $pages) {
            return null;
        }

        return $previousPage >= $this->getFirstPageNumber() ? $previousPage : null;
    }

    /**
     * @param int $currentPage
     * @param int $maximumLinks
     * @param int $itemsPerPage
     * @return int|null
     */
    public function getNextPageNumber(int $currentPage, int $maximumLinks, int $itemsPerPage): ?int
    {
        $nextPage = $currentPage + 1;

        return $nextPage <= $this->getNumberOfPages($maximumLinks, $itemsPerPage) ? $nextPage : null;
    }

    /**
     * @return int
     */
    protected function getFirstPageNumber(): int
    {
        return 1;
    }

    /**
     * @param int $maximumLinks
     * @param int $itemsPerPage
     * @return int
     */
    public function getLastPageNumber(int $maximumLinks, int $itemsPerPage): int
    {
        return $this->getNumberOfPages($maximumLinks, $itemsPerPage);
    }

    /**
     * @param int $maximumLinks
     * @param int $itemsPerPage
     * @return array
     */
    public function getAllPageNumbers(int $maximumLinks, int $itemsPerPage): array
    {
        return range($this->getFirstPageNumber(), $this->getLastPageNumber($maximumLinks, $itemsPerPage));
    }
}
