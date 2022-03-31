<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\BookedService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BookedController extends ActionController
{
    /**
     * @var BookedService
     */
    protected $bookedService;

    /**
     * @param BookedService $bookedService
     */
    public function injectBookedService(BookedService $bookedService): void
    {
        $this->bookedService = $bookedService;
    }

    /**
     * @throws \JsonException
     */
    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject()->data;
        $booked = $this->bookedService->getBooked();

        $this->view->assignMultiple([
            'booked' => $booked,
            'content' => $content
        ]);
    }
}
