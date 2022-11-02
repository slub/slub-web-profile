<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\PaginatorService;
use Slub\SlubWebProfile\Service\ReserveService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ReserveController extends ActionController
{
    /**
     * @var ReserveService
     */
    protected $reserveService;

    /**
     * @var PaginatorService
     */
    protected $paginatorService;

    /**
     * @param ReserveService $reserveService
     */
    public function injectReserveService(ReserveService $reserveService): void
    {
        $this->reserveService = $reserveService;
    }

    /**
     * @param PaginatorService $paginatorService
     */
    public function injectPaginatorService(PaginatorService $paginatorService): void
    {
        $this->paginatorService = $paginatorService;
    }

    public function currentAction(): void
    {
        $reserveCurrent = $this->reserveService->getReserveCurrent();
        $this->view->assign('reserveCurrent', $reserveCurrent);
    }

    public function historyAction(): void
    {
        $page = $this->getPage();

        $reserveHistoryData = $this->reserveService->getReserveHistory($page);
        $paginator = $this->paginatorService->getPaginator($reserveHistoryData['paginator']);

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'reserveHistory' => $reserveHistoryData['reserveHistory']
        ]);
    }

    /**
     * @return int
     */
    private function getPage(): int
    {
        $page = (int)$this->request->getArguments()['currentPage'];

        if ($page === 0) {
            $page = 1;
        }

        return $page;
    }
}
