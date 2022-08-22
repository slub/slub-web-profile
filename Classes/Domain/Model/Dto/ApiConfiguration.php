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
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationExtensionNotConfiguredException;
use TYPO3\CMS\Core\Configuration\Exception\ExtensionConfigurationPathDoesNotExistException;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Context\Exception\AspectNotFoundException;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class ApiConfiguration
{
    public const PLACEHOLDER = [
        'userId' => '###USER_ID###',
        'userCategory' => '###USER_CATEGORY###'
    ];

    /**
     * @var string
     */
    protected $bookedListUri;

    /**
     * @var string
     */
    protected $bookmarkListUri;

    /**
     * @var string
     */
    protected $eventListUri;

    /**
     * @var string
     */
    protected $messageListUri;

    /**
     * @var string
     */
    protected $userAccountDetailUri;

    /**
     * @var string
     */
    protected $userAccountUpdateUri;

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
    protected $userSearchQueryDetailUri;

    /**
     * @var string
     */
    protected $userSearchQueryUpdateUri;

    /**
     * @throws Exception
     * @throws AspectNotFoundException
     * @throws ExtensionConfigurationPathDoesNotExistException
     * @throws ExtensionConfigurationExtensionNotConfiguredException
     */
    public function __construct()
    {
        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        $languageUid = LanguageUtility::getUid() ?? 0;
        $domain = $extensionConfiguration->get(ConstantsUtility::EXTENSION_KEY, 'apiDomain');
        $settings = $this->getPluginSettings();
        $paths = $this->preparePaths($settings['api']['path']);

        $this->setBookedListUri($domain . $paths['bookedList']);
        $this->setBookmarkListUri($domain . $paths['bookmarkList']);
        $this->setEventListUri($domain . $paths['eventList'][$languageUid]);
        $this->setMessageListUri($domain . $paths['messageList'][$languageUid]);
        $this->setUserAccountDetailUri($domain . $paths['userAccountDetail'][$languageUid]);
        $this->setUserAccountUpdateUri($domain . $paths['userAccountUpdate']);
        $this->setUserDashboardDetailUri($domain . $paths['userDashboardDetail']);
        $this->setUserDashboardUpdateUri($domain . $paths['userDashboardUpdate']);
        $this->setUserSearchQueryDetailUri($domain . $paths['userSearchQueryDetail']);
        $this->setUserSearchQueryUpdateUri($domain . $paths['userSearchQueryUpdate']);
    }

    /**
     * @return string
     */
    public function getBookedListUri(): string
    {
        return $this->bookedListUri;
    }

    /**
     * @param string $bookedListUri
     */
    public function setBookedListUri(string $bookedListUri = ''): void
    {
        $this->bookedListUri = $bookedListUri;
    }

    /**
     * @return string
     */
    public function getBookmarkListUri(): string
    {
        return $this->bookmarkListUri;
    }

    /**
     * @param string $bookmarkListUri
     */
    public function setBookmarkListUri(string $bookmarkListUri = ''): void
    {
        $this->bookmarkListUri = $bookmarkListUri;
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
    public function setEventListUri(string $eventListUri = ''): void
    {
        $this->eventListUri = $eventListUri;
    }

    /**
     * @return string
     */
    public function getMessageListUri(): string
    {
        return $this->messageListUri;
    }

    /**
     * @param string $messageListUri
     */
    public function setMessageListUri(string $messageListUri = ''): void
    {
        $this->messageListUri = $messageListUri;
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
    public function setUserAccountDetailUri(string $userAccountDetailUri = ''): void
    {
        $this->userAccountDetailUri = $userAccountDetailUri;
    }

    /**
     * @return string
     */
    public function getUserAccountUpdateUri(): string
    {
        return $this->userAccountUpdateUri;
    }

    /**
     * @param string $userAccountUpdateUri
     */
    public function setUserAccountUpdateUri(string $userAccountUpdateUri = ''): void
    {
        $this->userAccountUpdateUri = $userAccountUpdateUri;
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
    public function setUserDashboardDetailUri(string $userDashboardDetailUri = ''): void
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
    public function setUserDashboardUpdateUri(string $userDashboardUpdateUri = ''): void
    {
        $this->userDashboardUpdateUri = $userDashboardUpdateUri;
    }

    /**
     * @return string
     */
    public function getUserSearchQueryDetailUri(): string
    {
        return $this->userSearchQueryDetailUri;
    }

    /**
     * @param string $userSearchQueryDetailUri
     */
    public function setUserSearchQueryDetailUri(string $userSearchQueryDetailUri = ''): void
    {
        $this->userSearchQueryDetailUri = $userSearchQueryDetailUri;
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
    public function setUserSearchQueryUpdateUri(string $userSearchQueryUpdateUri = ''): void
    {
        $this->userSearchQueryUpdateUri = $userSearchQueryUpdateUri;
    }

    /**
     * We need to have a valid user with data (not only the id) first, to get the
     * his user category. With calling this function you update some specific uri
     * who need more than just the user id.
     *
     * @param array $user
     */
    public function updatePaths(array $user): void
    {
        $this->setMessageListUri(
            str_replace(
                self::PLACEHOLDER['userCategory'],
                $user['account']['X_category'],
                $this->getMessageListUri()
            )
        );
    }

    /**
     * @return array
     */
    protected function getPluginSettings(): array
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

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
        $userId = (string)FrontendUserUtility::getIdentifier();

        foreach ($paths as $key => $path) {
            if (is_array($path)) {
                foreach ($path as $pathItem) {
                    $preparedPaths[$key][] = str_replace(self::PLACEHOLDER['userId'], $userId, $pathItem);
                }
            } else {
                $preparedPaths[$key] = str_replace(self::PLACEHOLDER['userId'], $userId, $path);
            }
        }

        return $preparedPaths;
    }
}
