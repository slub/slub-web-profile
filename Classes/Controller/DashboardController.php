<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Controller;

use Slub\SlubWebProfile\Service\DashboardService;
use Slub\SlubWebProfile\Service\WidgetService;
use Slub\SlubWebProfile\Utility\LanguageUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class DashboardController extends ActionController
{
    /**
     * @var DashboardService
     */
    protected $dashboardService;

    /**
     * @var WidgetService
     */
    protected $widgetService;

    /**
     * @param DashboardService $dashboardService
     */
    public function injectDashboardService(DashboardService $dashboardService): void
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * @param WidgetService $widgetService
     */
    public function injectWidgetService(WidgetService $widgetService): void
    {
        $this->widgetService = $widgetService;
    }

    public function showAction(): void
    {
        $content = $this->configurationManager->getContentObject()->data;
        $languageUid = LanguageUtility::getUid();
        $dashboardUid = $content['uid'];
        $pageUid = $content['pid'];

        if ($languageUid > 0) {
            $dashboardLocalized = $this->dashboardService->getLocalizedRecord($dashboardUid, $languageUid);
            $dashboardUid = $dashboardLocalized['uid'];
            $pageUid = $dashboardLocalized['pid'];
        }

        $this->view->assignMultiple([
            'widgets' => $this->widgetService->findByDashboard($dashboardUid),
            'uri' => LanguageUtility::getSiteLanguage($pageUid)->getBase()
        ]);
    }
}
