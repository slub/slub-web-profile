<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Http;

use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class Request implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public $options = [
        'headers' => ['Cache-Control' => 'no-cache'],
        'allow_redirects' => 0
    ];

    /**
     * @var RequestFactory $requestFactory
     */
    protected $requestFactory;

    public function __construct()
    {
        $this->requestFactory = GeneralUtility::makeInstance(RequestFactory::class);
    }

    /**
     * @param string $uri
     * @param string $method
     * @param array $options
     * @return array|null
     * @throws \JsonException
     */
    public function process($uri = '', $method = 'GET', array $options = []): ?array
    {
        try {
            $options = $this->mergeOptions($this->options, $options);
            $response = $this->requestFactory->request($uri, $method, $options);

            return $this->getContent($response, $uri);
        } catch (RequestException $e) {
            /** @extensionScannerIgnoreLine */
            $this->logger->error($e->getMessage());

            return null;
        }
    }

    /**
     * @param array $default
     * @param array $options
     * @return array
     */
    protected function mergeOptions(array $default, array $options): array
    {
        count($options) === 0 ?: ArrayUtility::mergeRecursiveWithOverrule($default, $options);

        return $default;
    }

    /**
     * @param ResponseInterface $response
     * @param string $uri
     * @return array|null
     * @throws \JsonException
     */
    protected function getContent(ResponseInterface $response, $uri = ''): ?array
    {
        $content = '';

        if ($response->getStatusCode() === 200 && strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
            $content = (array)json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        }

        if (empty($content)) {
            $this->logger->warning(
                'Requesting request was not successful.',
                [
                    'request' => $uri,
                    'status' => $response->getStatusCode(),
                    'reason' => $response->getReasonPhrase(),
                ]
            );

            return null;
        }

        return $content;
    }
}
