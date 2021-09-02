<?php

defined('TYPO3') || die();

// Add tsconfig page
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_web_profile/Configuration/TsConfig/Page.tsconfig"'
);

// Add tsconfig user
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig(
    '@import "EXT:slub_web_profile/Configuration/TsConfig/User.tsconfig"'
);
