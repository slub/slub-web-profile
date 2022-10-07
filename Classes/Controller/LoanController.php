<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\loanService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class loanController extends ActionController
{
    /**
     * @var loanService
     */
    protected $loanService;

    /**
     * @param loanService $loanService
     */
    public function injectloanService(loanService $loanService): void
    {
        $this->loanService = $loanService;
    }

    /**
     * @throws \JsonException
     */
    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $loanCurrent = [
            0 => [
                'uid' => 1,
                'title' => 'Kiehnle-Kochbuch',
                'date-available' => '2022-05-01T12:55:00+00:00',
                'date-loan' => '2022-05-03T12:55:00+00:00',
                'date-due' => '2022-06-10T10:21:00+00:00',
                'date-return' => '',
                'renewals' => '3',
                'barcode' => '30688558',
                'author' => 'Kiehnle, Hermine'
            ],
            1 => [
                'uid' => 2,
                'title' => 'Technik und Zubehör Makerspace SLUB Dresden',
                'date-available' => '2022-06-28T10:21:00+00:00',
                'date-loan' => '',
                'date-due' => '',
                'date-return' => '',
                'renewals' => '1',
                'barcode' => '34157322',
                'author' => ''
            ]
        ];

        $loanHistory = [
            0 => [
                'uid' => 1,
                'title' => 'Die Ernährungs-Docs - Gesunde Haut',
                'date-loan' => '2022-04-25T07:14:30+00:00',
                'date-return' => '2022-05-23T08:17:48+00:00',
                'barcode' => '33499286',
                'author' => 'Riedl, Matthias'
            ],
            1 => [
                'uid' => 2,
                'title' => 'Neuron-glia interactions mediated by P2 receptor activation',
                'date-loan' => '2022-04-13T11:26:05+00:00',
                'date-return' => '2022-07-28T08:18:30+00:00',
                'barcode' => '31918375',
                'author' => 'Pedreira de Oliveira, João Filipe'
            ]
        ];

        $this->view->assignMultiple([
            'loanCurrent' => $loanCurrent,
            'loanHistory' => $loanHistory
        ]);
       
        // TODO: Integrate API 
        /* 
        $loanCurrent = $this->loanService->getloanCurrent();
        $loanHistory = $this->loanService->getloanHistory();

        $this->view->assignMultiple([
            'loanCurrent' => $loanCurrent,
            'loanHistory' => $loanHistory
        ]);
        */
    }
}
