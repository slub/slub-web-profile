<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\ReserveService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class ReserveController extends ActionController
{
    /**
     * @var ReserveService
     */
    protected $reserveService;

    /**
     * @param ReserveService $reserveService
     */
    public function injectReserveService(ReserveService $reserveService): void
    {
        $this->reserveService = $reserveService;
    }

    /**
     * @throws \JsonException
     */
    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $reserves = [
            0 => [
                'uid' => 1,
                'title' => 'Hundertfünfzig Jahre Künstlerverein Malkasten',
                'crdate' => '2022-09-07T14:00:00+00:00',
                'position' => 3,
                'barcode' => '34750495',
                'author' => 'Lohmann, Julia [Red.]'
            ],
            1 => [
                'uid' => 2,
                'title' => 'Technik und Zubehör Makerspace SLUB Dresden',
                'crdate' => '2022-05-18T14:00:00+00:00',
                'position' => 1,
                'barcode' => '0',
                'author' => ''
            ],
            2 => [
                'uid' => 3,
                'title' => 'Entwicklungsberatung unter dem Aspekt der Lebensspanne',
                'crdate' => '2022-04-04T00:00:00+00:00',
                'position' => 12,
                'barcode' => '10140863',
                'author' => 'Aschenbach, Günter'
            ],
            3 => [
                'uid' => 4,
                'title' => '"City-Logistik"',
                'crdate' => '2022-08-25T00:00:00+00:00',
                'position' => '',
                'barcode' => '33127523',
                'author' => 'Wolpert, Stefan'
            ]
        ];

        $this->view->assignMultiple([
            'reserveCurrent' => $reserves,
            'reserveHistory' => $reserves
        ]);
       
        // TODO: Integrate API 
        /* 
        $reserveCurrent = $this->reserveService->getReserveCurrent();
        $reserveHistory = $this->reserveService->getReserveHistory();

        $this->view->assignMultiple([
            'reserveCurrent' => $reserveCurrent,
            'reserveHistory' => $reserveHistory
        ]);
        */
    }
}
