<?php

defined('TYPO3_MODE') || die();

// Add tsconfig page
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '@import "EXT:slub_web_profile/Configuration/TsConfig/Page.tsconfig"'
);

// Configure plugin - dashboard
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'Dashboard',
    [
        'Dashboard' => 'show'
    ],
    [
        'Dashboard' => 'show'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - event list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'EventList',
    [
        'Event' => 'list'
    ],
    [
        'Event' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - borrowing list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'BorrowingList',
    [
        'Borrowing' => 'list'
    ],
    [
        'Borrowing' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - user detail
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'UserDetail',
    [
        'User' => 'detail'
    ],
    [
        'User' => 'detail'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - search query list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'SearchQueryList',
    [
        'SearchQuery' => 'list'
    ],
    [
        'SearchQuery' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Register icon
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

foreach ([
    'wizard-dashboard' => 'Wizard/dashboard',
    'wizard-eventfilter' => 'Wizard/event-filter',
    'wizard-eventlist' => 'Wizard/event-list',
    'wizard-borrowinglist' => 'Wizard/borrowing-list',
    'wizard-userdetail' => 'Wizard/user-detail',
    'wizard-searchquerylist' => 'Wizard/search-query-list'
] as $identifier => $path) {
    $iconRegistry->registerIcon(
        'slubwebprofile-' . $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:slub_web_profile/Resources/Public/Icons/' . $path . '.svg']
    );
}
