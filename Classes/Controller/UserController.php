<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\UserAccountService as UserService;
use Slub\SlubWebProfile\Utility\MenuUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class UserController extends ActionController
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

    public function detailAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject();
        $user = $this->userService->getUserAccount();
        $pages = MenuUtility::getList($content)['menu'];
        $profilName = $this->configurationManager->getContentObject()->data['subheader'];
        $profilLink = $this->configurationManager->getContentObject()->data['header_link'];

        $this->view->assignMultiple([
            'user' => $user,
            'pages' => $pages,
            'profilName' => $profilName,
            'profilLink' => $profilLink
        ]);
    }
}
