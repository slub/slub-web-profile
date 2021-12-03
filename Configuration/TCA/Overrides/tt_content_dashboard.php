<?php

defined('TYPO3_MODE') || die();

(static function (string $extensionKey, string $contentElementName): void {
    /** @var Slub\SlubWebProfile\DataProvider\TcaSelectItems $tcaSelectItems */
    $tcaSelectItems = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
        Slub\SlubWebProfile\DataProvider\TcaSelectItems::class
    );

    $extensionName = str_replace('_', '', $extensionKey);
    $ll = [
        'backend' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_backend.xlf',
        'tca' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_tca.xlf',
        'core' => 'LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf',
        'frontend' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf'
    ];
    $newColumns = [
        'tt_content' => [
            'exclude' => true,
            'label' => $ll['tca'] . ':tt_content.widgets',
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'tt_content',
                'foreign_field' => 'irre_parent_uid',
                'foreign_table_field' => 'irre_parent_table',
                'foreign_sortby' => 'sorting',
                'appearance' => [
                    'useSortable' => true,
                    'showSynchronizationLink' => true,
                    'showAllLocalizationLink' => true,
                    'showPossibleLocalizationRecords' => true,
                    'showRemovedLocalizationRecords' => false,
                    'expandSingle' => true,
                    'enabledControls' => [
                        'localize' => true,
                    ]
                ],
                'minitems' => 1,
                'maxitems' => 99,
                'behaviour' => [
                    'mode' => 'select',
                ],
                'overrideChildTca' => [
                    'columns' => [
                        'colPos' => [
                            'config' => [
                                'default' => '999'
                            ]
                        ],
                        'CType' => [
                            'config' => [
                                'default' => 'slubwebprofile_eventlist',
                                'itemsProcFunc' => \Slub\SlubWebProfile\DataProvider\TcaSelectItems::class . '->getDashboardCTypes'
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ];

    // Add columns
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
        'tt_content',
        $newColumns
    );

    // Merge content element definition
    TYPO3\CMS\Core\Utility\ArrayUtility::mergeRecursiveWithOverrule($GLOBALS['TCA']['tt_content'], [
        'ctrl' => [
            'typeicon_classes' => [
                $extensionName . '_' . $contentElementName => $extensionName . '-wizard-' . $contentElementName,
            ],
        ],
        'types' => [
            $extensionName . '_' . $contentElementName => [
                'showitem' => '
                    --div--;' . $ll['core'] . ':general,
                        --palette--;' . $ll['frontend'] . ':palette.general;general,
                        --palette--;' . $ll['frontend'] . ':palette.headers;headers,
                        tt_content,
                    --div--;' . $ll['frontend'] . ':tabs.appearance,
                        --palette--;' . $ll['frontend'] . ':palette.frames;frames,
                        --palette--;' . $ll['frontend'] . ':palette.appearanceLinks;appearanceLinks,
                    --div--;' . $ll['core'] . ':language,
                        --palette--;;language,
                    --div--;' . $ll['core'] . ':access,
                        --palette--;;hidden,
                        --palette--;' . $ll['frontend'] . ':palette.access;access,
                    --div--;' . $ll['core'] . ':categories,
                        categories,
                    --div--;' . $ll['core'] . ':notes,
                        rowDescription,
                    --div--;' . $ll['core'] . ':extended,',
            ],
        ],
    ]);

    // Add item to select field list (ctype)
    TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTcaSelectItem(
        'tt_content',
        'CType',
        [
            $ll['backend'] . ':contentElement.' . $contentElementName . '.title',
            $extensionName . '_' . $contentElementName,
            $extensionName . '-wizard-' . $contentElementName
        ]
    );
})(
    'slub_web_profile',
    'dashboard'
);
