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
    public const PLACEHOLDER = [
        'userId' => '###USER_ID###',
        'userCategory' => '###USER_CATEGORY###'
    ];

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

    public function __construct()
    {
        /** @var ExtensionConfiguration $extensionConfiguration */
        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);

        $languageUid = LanguageUtility::getUid() ?? 0;
        $domain = $extensionConfiguration->get(ConstantsUtility::EXTENSION_KEY, 'apiDomain');
        $settings = $this->getPluginSettings();
        $paths = $this->preparePaths($settings['api']['path']);

        $this->setEventListUri($domain . $paths['eventList'][$languageUid]);
        $this->setMessageListUri($domain . $paths['messageList'][$languageUid]);
        $this->setUserAccountDetailUri($domain . $paths['userAccountDetail']);
        $this->setUserDashboardDetailUri($domain . $paths['userDashboardDetail']);
        $this->setUserDashboardUpdateUri($domain . $paths['userDashboardUpdate']);
        $this->setUserSearchQueryDetailUri($domain . $paths['userSearchQueryDetail']);
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
    public function getMessageListUri(): string
    {
        return $this->messageListUri;
    }

    /**
     * @param string $messageListUri
     */
    public function setMessageListUri($messageListUri = ''): void
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
    public function getUserSearchQueryDetailUri(): string
    {
        return $this->userSearchQueryDetailUri;
    }

    /**
     * @param string $userSearchQueryDetailUri
     */
    public function setUserSearchQueryDetailUri($userSearchQueryDetailUri = ''): void
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
    public function setUserSearchQueryUpdateUri($userSearchQueryUpdateUri = ''): void
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
                $user['accountData']['X_category'],
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
        $userId = FrontendUserUtility::getIdentifier();

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
