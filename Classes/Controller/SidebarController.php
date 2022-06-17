<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Utility\MenuUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class SidebarController extends ActionController
{
    /**
     * @throws \JsonException
     */
    public function detailAction(): void
    {
        /** @extensionScannerIgnoreLine */
        $content = $this->configurationManager->getContentObject();
        $pages = MenuUtility::getList($content)['menu'];

        $this->view->assignMultiple([
            'pages' => $pages
        ]);
    }
}
