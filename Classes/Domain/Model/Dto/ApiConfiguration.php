<?php

declare(strict_types=1);

/*
 * This file is part of the package slub/slub-web-profile
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Slub\SlubWebProfile\Domain\Model\Dto;

use Slub\SlubWebProfile\Utility\ConstantsUtility;
use Slub\SlubWebProfile\Utility\FrontendUserUtility;
use Slub\SlubWebProfile\Utility\LanguageUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ApiConfiguration
{
    /**
     * @var string
     */
    protected $eventListUri;

    /**
     * @var string
     */
    protected $userAccountDetailUri;

    /**
     * @var string
     */
    protected $userDashboardDetailUri;

    /**
     * @var string
     */
    protected $userDashboardUpdateUri;

    /**
     * @var string
     */
    protected $userSearchQueryUpdateUri;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        $languageUid = LanguageUtility::getUid() ?? 0;
        $domain = $extensionConfiguration->get(ConstantsUtility::EXTENSION_KEY, 'apiDomain');

        $settings = $this->getPluginSettings();
        $paths = $this->preparePaths($settings['api']['path']);

        $this->setEventListUri($domain . $paths['eventList'][$languageUid]);
        $this->setUserAccountDetailUri($domain . $paths['userAccountDetail']);
        $this->setUserDashboardDetailUri($domain . $paths['userDashboardDetail']);
        $this->setUserDashboardUpdateUri($domain . $paths['userDashboardUpdate']);
        $this->setUserSearchQueryUpdateUri($domain . $paths['userSearchQueryUpdate']);
    }

    /**
     * @return string
     */
    public function getEventListUri(): string
    {
        return $this->eventListUri;
    }

    /**
     * @param string $eventListUri
     */
    public function setEventListUri($eventListUri = ''): void
    {
        $this->eventListUri = $eventListUri;
    }

    /**
     * @return string
     */
    public function getUserAccountDetailUri(): string
    {
        return $this->userAccountDetailUri;
    }

    /**
     * @param string $userAccountDetailUri
     */
    public function setUserAccountDetailUri($userAccountDetailUri = ''): void
    {
        $this->userAccountDetailUri = $userAccountDetailUri;
    }

    /**
     * @return string
     */
    public function getUserDashboardDetailUri(): string
    {
        return $this->userDashboardDetailUri;
    }

    /**
     * @param string $userDashboardDetailUri
     */
    public function setUserDashboardDetailUri($userDashboardDetailUri = ''): void
    {
        $this->userDashboardDetailUri = $userDashboardDetailUri;
    }

    /**
     * @return string
     */
    public function getUserDashboardUpdateUri(): string
    {
        return $this->userDashboardUpdateUri;
    }

    /**
     * @param string $userDashboardUpdateUri
     */
    public function setUserDashboardUpdateUri($userDashboardUpdateUri = ''): void
    {
        $this->userDashboardUpdateUri = $userDashboardUpdateUri;
    }

    /**
     * @return string
     */
    public function getUserSearchQueryUpdateUri(): string
    {
        return $this->userSearchQueryUpdateUri;
    }

    /**
     * @param string $userSearchQueryUpdateUri
     */
    public function setUserSearchQueryUpdateUri($userSearchQueryUpdateUri = ''): void
    {
        $this->userSearchQueryUpdateUri = $userSearchQueryUpdateUri;
    }

    /**
     * @return array
     */
    protected function getPluginSettings(): array
    {
        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);

        return $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            ConstantsUtility::EXTENSION_NAME
        );
    }

    /**
     * @param array $paths
     * @return array
     * @throws AspectNotFoundException|Exception
     */
    protected function preparePaths(array $paths): array
    {
        $preparedPaths = [];
        $userIdentifier = FrontendUserUtility::getIdentifier();

        foreach ($paths as $key => $path) {
            if (is_array($path)) {
                foreach ($path as $pathItem) {
                    $preparedPaths[$key][] = $this->replaceUserId($userIdentifier, $pathItem);
                }
            } else {
                $preparedPaths[$key] = $this->replaceUserId($userIdentifier, $path);
            }
        }

        return $preparedPaths;
    }

    /**
     * @param int $userId
     * @param string $string
     * @return string
     */
    protected function replaceUserId(int $userId, string $string): string
    {
        return str_replace(
            ConstantsUtility::PLACEHOLDER['userId'],
            $userId,
            $string
        );
    }
}
