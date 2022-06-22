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
use Slub\SlubWebProfile\Utility\FrontendUserUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class AccountFormController extends ActionController
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

    /**
     * @var array
     */
    private $formTypes = [
        1 => 'profile',
        2 => 'address',
        3 => 'social'
    ];

    public function indexAction(): void
    {
        // flexform formtyp - call to action controller
        $formType = (int)$this->settings['formtyp'];
        $this->forward($this->formTypes[$formType]);
    }

    /**
     * @throws \JsonException
     */
    public function profileAction(): void
    {
        $status = $this->updateUser();
        $this->assignUserData($status);
    }

    /**
     * @throws \JsonException
     */
    public function addressAction(): void
    {
        $status = $this->updateUser();
        $this->assignUserData($status);
    }

    /**
     * @throws \JsonException
     */
    public function socialAction(): void
    {
        $status = $this->updateUser();
        $this->assignUserData($status);
    }

    /**
     * @return array
     */
    protected function updateUser(): array
    {
        if (is_array($_POST['account'])) {
            $userIdentifier = FrontendUserUtility::getIdentifier();
            return $this->userService->updateUserAccount($userIdentifier, $_POST['account']);
        }
        return [];
    }

    /**
     * @param array $status
     */
    protected function assignUserData(array $status): void
    {
        $user = $this->userService->getUserAccount();

        $this->view->assignMultiple([
            'user' => $user,
            'status' => $status
        ]);
    }
}
