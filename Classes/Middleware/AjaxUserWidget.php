<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slub\SlubWebProfile\Service\UserService;
use Slub\SlubWebProfile\Utility\ConstantsUtility;
use Slub\SlubWebProfile\Utility\FrontendUserUtility;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Http\Response;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class AjaxUserWidget implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $action = '';

    /**
     * @var array
     */
    protected $widgets = [];

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct()
    {
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->userService = $objectManager->get(UserService::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws AspectNotFoundException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);
        $userWidget = (int)$request->getQueryParams()['tx_' . ConstantsUtility::EXTENSION_NAME . '_ajax']['userWidget'];
        $userIdentifier = $this->getUserIdentifier();

        if ($userWidget === 0 || $userIdentifier === 0) {
            return $response;
        }

        $content = $this->getContent();

        $this->setAction($content);
        $this->setWidgets($content);

        //@todo include this condition again
        /*if ($this->action !== 'update') {
            return $response;
        }*/

        $x = $this->userService->updateUser($userIdentifier, $this->widgets);

        // @todo remove test data
        $data = [
            'usr' => $userIdentifier,
            'widgets' => implode(', ', $this->widgets),
            'status' => 'ok',
            'x' => $x
        ];

        $responseBody = new Stream('php://temp', 'rw');
        $responseBody->write(json_encode($data));

        return (new Response())
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withBody($responseBody)
            ->withStatus(200);
    }

    protected function setWidgets(array $content): void
    {
        $this->widgets = $content['widgets'] ?? [];
    }

    /**
     * @param array $content
     */
    protected function setAction(array $content): void
    {
        $this->action = $content['action'] ?? '';
    }

    /**
     * @return array
     */
    protected function getContent(): array
    {
        return json_decode(file_get_contents('php://input'), true) ?? [];
    }

    /**
     * @return int
     * @throws AspectNotFoundException
     */
    protected function getUserIdentifier(): int
    {
        return FrontendUserUtility::getIdentifier();
    }
}
