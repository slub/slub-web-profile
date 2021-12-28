<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\EventService;
use Slub\SlubWebProfile\Utility\LanguageUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class EventController extends ActionController
{
    /**
     * @var EventService
     */
    protected $eventService;

    /**
     * @param EventService $eventService
     */
    public function injectEventService(EventService $eventService): void
    {
        $this->eventService = $eventService;
    }

    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject()->data;
        $events = $this->eventService->getEvents();
        $language = LanguageUtility::getSiteLanguage($content['pid']);

        $this->view->assignMultiple([
            'events' => $events,
            'language' => $language,
            'content' => $content
        ]);
    }
}
