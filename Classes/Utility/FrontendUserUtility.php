<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Utility;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FrontendUserUtility
{
    /**
     * @return int
     * @throws AspectNotFoundException
     */
    public static function getIdentifier(): int
    {
        /** @var Context $context */
        $context = GeneralUtility::makeInstance(Context::class);

        return (int)$context->getPropertyFromAspect('frontend.user', 'username');
    }
}
