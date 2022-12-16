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
 * Removes chars from string
 *
 * Examples
 * ========
 *
 * Regular syntax
 * --------------
 *
 * <slub:format.charRemove chars="{string}" />
 */
class CharRemoveViewHelper extends AbstractViewHelper
{
    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * Register arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('content', 'string', 'Content string', false, null);
        $this->registerArgument('chars', 'string', 'Comma seperated list of chars', true, null);
    }

    /**
     * @return string
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $content = $arguments['content'];
        $chars = $arguments['chars'];

        if ($content === null) {
            $content = $renderChildrenClosure();
        }
        $content = trim($content);
        if ($chars !== null) {
            $chars = explode(',', $chars);
            return trim(str_replace($chars, '', $content));
        }
        return $content;
    }
}
