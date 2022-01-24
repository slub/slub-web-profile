<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Middleware;

use JsonException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slub\SlubWebProfile\Service\UserDashboardService as UserService;
use Slub\SlubWebProfile\Service\WidgetService;
use Slub\SlubWebProfile\Utility\ConstantsUtility;
use Slub\SlubWebProfile\Utility\FileUtility;
use Slub\SlubWebProfile\Utility\FrontendUserUtility;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Exception;
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
     * @throws JsonException|Exception
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);
        $userWidget = (int)$request->getQueryParams()['tx_' . ConstantsUtility::EXTENSION_NAME . '_ajax']['userWidget'];
        $userIdentifier = FrontendUserUtility::getIdentifier();

        if ($userWidget === 0 || $userIdentifier === 0) {
            return $response;
        }

        $content = FileUtility::getContent();

        if ($content['action'] !== 'update') {
            return $response;
        }

        $responseDashboard = (array)$this->userService->updateUserDashboard(
            $userIdentifier,
            [
                'body' => json_encode([
                    'widgets' => $this->getWidgets(
                        (int)$content['pageUid'],
                        (array)$content['widgets']
                    )
                ], JSON_THROW_ON_ERROR)
            ]
        );

        $responseBody = new Stream('php://temp', 'rw');
        $responseBody->write(json_encode($responseDashboard, JSON_THROW_ON_ERROR));

        return (new Response())
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withBody($responseBody)
            ->withStatus(200);
    }

    /**
     * @param int $pageUid
     * @param array $widgets
     * @return array
     */
    protected function getWidgets(int $pageUid, array $widgets): array
    {
        $allowedWidgets = $this->widgetService->getAllowedWidgets($pageUid);

        return $this->widgetService->validateWidgets($widgets, $allowedWidgets);
    }
}
