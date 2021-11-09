<?php

defined('TYPO3_MODE') || die();

// Add an extra optgroup
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
    'tt_content',
    'CType',
    [
        'LLL:EXT:slub_web_profile/Resources/Private/Language/locallang_backend.xlf:extension.title',
        '--div--'
    ]
);
