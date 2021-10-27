<?php

defined('TYPO3_MODE') || die();

// Add static typoscript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'slub_web_profile',
    'Configuration/TypoScript/',
    'SLUB Web Profile'
);
