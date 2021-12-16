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
use Slub\SlubWebProfile\Service\WidgetService;
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
     * @var UserService
     */
    protected $userService;

    /**
     * @var WidgetService
     */
    protected $widgetService;

    public function __construct()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->userService = $objectManager->get(UserService::class);
        $this->widgetService = $objectManager->get(WidgetService::class);
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
        $allowedWidgets = $this->widgetService->getAllowedWidgets((int)$content['pageUid']);
        $widgets = $this->widgetService->validateWidgets($content['widgets'], $allowedWidgets);

        //@todo include this condition again
        /*if ($content['action'] !== 'update') {
            return $response;
        }*/

        $x = $this->userService->updateUser($userIdentifier, $widgets);

        // @todo remove test data
        $data = [
            'usr' => $userIdentifier,
            'allowedWidgets' => implode(', ', $allowedWidgets),
            'widgets' => implode(', ', $widgets),
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
