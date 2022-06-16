<?php

defined('TYPO3_MODE') || die();

// Configure new fields:
$fields = [
    'tx_slubwebprofile_navigationSubtitle' => [
        'label' => 'LLL:EXT:slub_web_profile/Resources/Private/Language/locallang_backend.xlf:pages.tx_slubwebprofile_navigationSubtitle',
        'exclude' => 1,
        'config' => [
            'type' => 'input',
            'max' => 255
        ],
    ]
];

// Add new fields to pages:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages', $fields);

// Make fields visible in the TCEforms:
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages',
    '--palette--;LLL:EXT:slub_web_profile/Resources/Private/Language/locallang_backend.xlf:pages.tx_slubwebprofile_profilmenu;tx_pagesaddfields',
    '1',
    'after:subtitle'
);

// Add the new palette:
$GLOBALS['TCA']['pages']['palettes']['tx_pagesaddfields'] = [
    'showitem' => 'tx_slubwebprofile_navigationSubtitle'
];