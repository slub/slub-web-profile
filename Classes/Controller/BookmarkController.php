<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\BookmarkService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class BookmarkController extends ActionController
{
    /**
     * @var BookmarkService
     */
    protected $bookmarkService;

    /**
     * @param BookmarkService $bookmarkService
     */
    public function injectBookmarkService(BookmarkService $bookmarkService): void
    {
        $this->bookmarkService = $bookmarkService;
    }

    /**
     * @throws \JsonException
     */
    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject()->data;
        $bookmarks = $this->bookmarkService->getBookmarks();

        $this->view->assignMultiple([
            'bookmarks' => $bookmarks,
            'content' => $content
        ]);
    }
}
