<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Set CSS Class depending on the due date
 *
 * Examples
 * ========
 *
 * Regular syntax
 * --------------
 *
 * <slub:format.dueDateClass days='{string}' />
 */
class DueDateClassViewHelper extends AbstractViewHelper
{
    /**
     * Register arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('days', 'string', 'The number of days until the item is due', true);
    }

    /**
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $days = (int)($arguments['days']);

        if ($days <= 0) {
            return 'item-overdue';
        }

        if ($days <= 5) {
            return 'item-soon-to-be-due';
        }

        return '';
    }
}
