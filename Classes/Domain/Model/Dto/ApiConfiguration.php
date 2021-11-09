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
use Slub\SlubWebProfile\Utility\LanguageUtility;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
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

        $this->setEventListUri($domain . $settings['api']['path']['eventList'][$languageUid]);
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
}
