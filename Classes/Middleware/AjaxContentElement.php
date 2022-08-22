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
use Slub\SlubWebProfile\Utility\ConstantsUtility;
use TYPO3\CMS\Core\Cache\Exception\InvalidDataException;
use TYPO3\CMS\Core\Http\Stream;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;

class AjaxContentElement implements MiddlewareInterface
{
    /**
     * @var array
     */
    protected $contentObjectConfiguration = [
        'tables' => 'tt_content',
        'dontCheckPid' => 1
    ];

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws InvalidDataException
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);
        $contentId = (int)$request->getQueryParams()['tx_' . ConstantsUtility::EXTENSION_NAME . '_ajax']['tt_content'];

        if ($contentId === 0) {
            return $response;
        }

        $content = $this->getContent($contentId);
        $content = $this->handleIntScript($content);

        $responseBody = new Stream('php://temp', 'rw');
        $responseBody->write($content);

        return $response->withBody($responseBody);
    }

    /**
     * HTML could contain <!-- INT_SCRIPT.12345 -->
     * Handle this script tag and replace with real content. Happens when elements
     * are not cached or plugins with not cached actions in configuration.
     *
     * @param string $html
     * @return string
     * @throws InvalidDataException
     */
    protected function handleIntScript(string $html): string
    {
        $frontendController = $this->getTypoScriptFrontendController();

        if ($frontendController === null) {
            throw new InvalidDataException('The specified data is "null" but "TypoScriptFrontendController" is expected.', 1277859941);
        }

        /** @extensionScannerIgnoreLine */
        $frontendController->content = $html;
        $frontendController->INTincScript();

        return $frontendController->content;
    }

    /**
     * @param int $id
     * @return string
     */
    protected function getContent(int $id): string
    {
        /** @var ContentObjectRenderer $contentObjectRenderer */
        $contentObjectRenderer = GeneralUtility::makeInstance(ContentObjectRenderer::class);

        $this->contentObjectConfiguration['source'] = $id;

        return $contentObjectRenderer->cObjGetSingle(
            'RECORDS',
            $this->contentObjectConfiguration
        );
    }

    /**
     * @return TypoScriptFrontendController|null
     */
    protected function getTypoScriptFrontendController(): ?TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'] ?? null;
    }
}
