<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Service;

use Slub\SlubWebProfile\Domain\Model\Dto\ApiConfiguration;
use Slub\SlubWebProfile\Http\Request;

class BookedService
{
    /**
     * @var ApiConfiguration
     */
    protected $apiConfiguration;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param ApiConfiguration $apiConfiguration
     */
    public function injectApiConfiguration(ApiConfiguration $apiConfiguration): void
    {
        $this->apiConfiguration = $apiConfiguration;
    }

    /**
     * @param Request $request
     */
    public function injectRequest(Request $request): void
    {
        $this->request = $request;
    }

    /**
     * @return array|null
     * @throws \JsonException
     */
    public function getBooked(): ?array
    {
        $uri = $this->apiConfiguration->getBookedListUri();

        return $this->request->process($uri)['booked'];
    }
}
