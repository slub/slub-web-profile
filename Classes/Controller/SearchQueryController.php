<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\UserSearchQueryService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SearchQueryController extends ActionController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param UserService $userService
     */
    public function injectUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }

    public function listAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject()->data;
        $user = $this->userService->getUserSearchQuery();

        $this->view->assignMultiple([
            'user' => $user,
            'content' => $content
        ]);
    }
}
