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
    protected $userDetailUri;

    /**
     * @var string
     */
    protected $userUpdateUri;

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
        $this->setUserDetailUri($domain . $paths['userDetail']);
        $this->setUserUpdateUri($domain . $paths['userUpdate']);
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
    public function getUserDetailUri(): string
    {
        return $this->userDetailUri;
    }

    /**
     * @param string $userDetailUri
     */
    public function setUserDetailUri($userDetailUri = ''): void
    {
        $this->userDetailUri = $userDetailUri;
    }

    /**
     * @return string
     */
    public function getUserUpdateUri(): string
    {
        return $this->userUpdateUri;
    }

    /**
     * @param string $userUpdateUri
     */
    public function setUserUpdateUri($userUpdateUri = ''): void
    {
        $this->userUpdateUri = $userUpdateUri;
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
     * @throws AspectNotFoundException
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
