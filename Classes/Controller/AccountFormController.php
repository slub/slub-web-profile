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
use Slub\SlubWebProfile\Service\UserAccountService as UserService;
use Slub\SlubWebProfile\Utility\FrontendUserUtility;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;

class AccountFormController extends ActionController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var array
     */
    private $formTypes = [
        1 => 'profile',
        2 => 'address',
        3 => 'social',
        4 => 'password',
        5 => 'userpin',
        6 => 'lock'
    ];

    /**
     * @param UserService $userService
     */
    public function injectUserService(UserService $userService): void
    {
        $this->userService = $userService;
    }

    /**
     * @throws StopActionException
     */
    public function indexAction(): void
    {
        // flexform formType - call to action controller
        $formType = (int)$this->settings['formType'];
        $this->forward($this->formTypes[$formType]);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function profileAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[1];
        $this->assignUserData($status, $action);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function addressAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[2];
        $this->assignUserData($status, $action);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function socialAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[3];
        $this->assignUserData($status, $action);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function passwordAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[4];
        $this->assignUserData($status, $action);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function userPINAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[5];
        $this->assignUserData($status, $action);
    }

    /**
     * @return void
     * @throws AspectNotFoundException
     * @throws Exception
     * @throws JsonException
     */
    public function lockAction(): void
    {
        $status = $this->updateUser();
        $action = $this->formTypes[6];
        $this->assignUserData($status, $action);
    }

    /**
     * @return array
     * @throws JsonException
     * @throws AspectNotFoundException
     * @throws Exception
     */
    protected function updateUser(): array
    {
        if (is_array($_POST['address'])) {
            $userIdentifier = FrontendUserUtility::getIdentifier();
            return $this->userService->updateUserAccount($userIdentifier, $_POST['address']);
        }

        if (is_array($_POST['profile'])) {
            $userIdentifier = FrontendUserUtility::getIdentifier();
            return $this->userService->updateUserAccount($userIdentifier, $_POST['profile']);
        }

        if (is_array($_POST['pin'])) {
            $userIdentifier = FrontendUserUtility::getIdentifier();
            return $this->userService->updateUserPin($userIdentifier, $_POST['pin']);
        }

        if (is_array($_POST['password'])) {
            $userIdentifier = FrontendUserUtility::getIdentifier();
            return $this->userService->updateUserPassword($userIdentifier, $_POST['password']);
        }

        return [];
    }

    /**
     * @param array $status
     * @param string $action
     * @return void
     * @throws JsonException
     */
    protected function assignUserData(array $status, string $action): void
    {
        $user = $this->userService->getUserAccount();

        $this->view->assignMultiple([
            'user' => $user,
            'status' => $status,
            'action' => $action,
            'currentAction' => $_POST['account']['action'],
            'userPost' => $_POST['account'],
            'addressPost' => $_POST['address'],
            'profilePost' => $_POST['profile'],
            'pinPost' => $_POST['pin'],
            'passwordPost' => $_POST['password']
        ]);
    }
}
