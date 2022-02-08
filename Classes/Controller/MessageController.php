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
use Slub\SlubWebProfile\Service\MessageService;
use Slub\SlubWebProfile\Service\UserAccountService as UserService;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class MessageController extends ActionController
{
    /**
     * @var MessageService
     */
    protected $messageService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @param MessageService $messageService
     */
    public function injectMessageService(MessageService $messageService): void
    {
        $this->messageService = $messageService;
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
        $user = $this->userService->getUserAccount();
        $messages = $this->messageService->getMessagesForUser($user);

        $this->view->assign('messages', $messages);
    }
}
