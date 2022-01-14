<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Utility;

class FileUtility
{
    /**
     * @return array
     * @throws \JsonException
     */
    public static function getContent(): array
    {
        $content = file_get_contents('php://input');

        if (empty($content)) {
            return [];
        }

        return json_decode(
            $content,
            true,
            512,
            JSON_THROW_ON_ERROR
        ) ?? [];
    }
}
