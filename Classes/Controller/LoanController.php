<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\LoanService;
use Slub\SlubWebProfile\Service\PaginatorService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class LoanController extends ActionController
{
    /**
     * @var LoanService
     */
    protected $loanService;

    /**
     * @var PaginatorService
     */
    protected $paginatorService;

    /**
     * @param LoanService $loanService
     */
    public function injectLoanService(LoanService $loanService): void
    {
        $this->loanService = $loanService;
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
        $loanCurrent = $this->loanService->getLoanCurrent();
        $this->view->assign('loanCurrent', $loanCurrent);
    }

    public function historyAction(): void
    {
        $page = $this->getPage();

        $loanHistoryData = $this->loanService->getLoanHistory($page);
        $paginator = $this->paginatorService->getPaginator($loanHistoryData['paginator']);

        $this->view->assignMultiple([
            'paginator' => $paginator,
            'loanHistory' => $loanHistoryData['loanHistory']
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
