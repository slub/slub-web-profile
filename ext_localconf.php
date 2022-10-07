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

// Configure plugin - booked list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'BookedList',
    [
        'Booked' => 'list'
    ],
    [
        'Booked' => 'list'
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

// Configure plugin - reserve list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'ReserveList',
    [
        'Reserve' => 'list'
    ],
    [
        'Reserve' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - loan list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'LoanList',
    [
        'Loan' => 'list'
    ],
    [
        'Loan' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - bookmark list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'BookmarkList',
    [
        'Bookmark' => 'list'
    ],
    [
        'Bookmark' => 'list'
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

// Configure plugin - message list
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'MessageList',
    [
        'Message' => 'list'
    ],
    [
        'Message' => 'list'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - sidebar menu
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'SidebarMenu',
    [
        'Sidebar' => 'detail'
    ],
    [
        'Sidebar' => 'detail'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Configure plugin - account form
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Slub.SlubWebProfile',
    'AccountForm',
    [
        'AccountForm' => 'index,profile,address,social,password,userPIN,lock'
    ],
    [
        'AccountForm' => 'index,profile,address,social,password,userPIN,lock'
    ],
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::PLUGIN_TYPE_CONTENT_ELEMENT
);

// Register icon
/** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

foreach ([
    'wizard-bookedlist' => 'Wizard/booked-list',
    'wizard-borrowinglist' => 'Wizard/borrowing-list',
    'wizard-reservelist' => 'Wizard/reserve-list',
    'wizard-loanlist' => 'Wizard/loan-list',
    'wizard-bookmarklist' => 'Wizard/bookmark-list',
    'wizard-dashboard' => 'Wizard/dashboard',
    'wizard-eventfilter' => 'Wizard/event-filter',
    'wizard-eventlist' => 'Wizard/event-list',
    'wizard-messagelist' => 'Wizard/message-list',
    'wizard-userdetail' => 'Wizard/user-detail',
    'wizard-searchquerylist' => 'Wizard/search-query-list',
    'wizard-sidebarmenu' => 'Wizard/sidebar-menu',
    'wizard-accountform' => 'Wizard/account-form'
] as $identifier => $path) {
    $iconRegistry->registerIcon(
        'slubwebprofile-' . $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:slub_web_profile/Resources/Public/Icons/' . $path . '.svg']
    );
}
