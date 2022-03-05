<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use JsonException;
use Slub\SlubWebProfile\Service\SearchQueryService;
use Slub\SlubWebProfile\Service\UserSearchQueryService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SearchQueryController extends ActionController
{
    /**
     * @var SearchQueryService
     */
    protected $searchQueryService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param SearchQueryService $searchQueryService
     */
    public function injectSearchQueryService(SearchQueryService $searchQueryService): void
    {
        $this->searchQueryService = $searchQueryService;
    }

    /**
     * @param UserService $userService
     */
    public function injectUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }

    /**
     * @throws JsonException
     */
    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject()->data;
        $user = $this->userService->getUserSearchQuery();
        $searchQuery = $this->searchQueryService->getSearchQuery($user);

        $this->view->assignMultiple([
            'searchQuery' => $searchQuery,
            'content' => $content
        ]);
    }
}
