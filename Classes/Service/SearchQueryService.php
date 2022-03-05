<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Service;

use JsonException;

class SearchQueryService
{
    /**
     * @param array $data
     * @return array
     * @throws JsonException
     */
    public function getSearchQuery(array $data): array
    {
        if (count($data['searchQuery']) === 0) {
            return [];
        }

        return $this->prepareSearchQuery($data['searchQuery']);
    }

    /**
     * @param array $data
     * @return array
     * @throws JsonException
     */
    protected function prepareSearchQuery(array $data): array
    {
        $searchQueries = [];

        foreach ($data as $searchQuery) {
            $searchQuery['queryPrepared'] = $this->prepareQuery($searchQuery['query']);
            $searchQueries[] = $searchQuery;
        }

        return $searchQueries;
    }

    /**
     * Resolve the json and rewrite an array with field as key and input as value
     *
     * @param string $query
     * @return array
     * @throws JsonException
     */
    protected function prepareQuery(string $query): array
    {
        $queryArray = (array)json_decode($query, true, 512, JSON_THROW_ON_ERROR);
        $queries = [];

        if (count($queryArray) === 0) {
            return $queries;
        }

        foreach ($queryArray as $queryItem) {
            $queries[$queryItem['field']] = $queryItem['input'];
        }

        return $queries;
    }
}
