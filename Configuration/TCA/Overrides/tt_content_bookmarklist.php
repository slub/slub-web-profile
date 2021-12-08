<?php

defined('TYPO3_MODE') || die();

(static function (string $extensionKey, string $contentElementName): void {
    $extensionName = str_replace('_', '', $extensionKey);
    $ll = [
        'backend' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_backend.xlf',
        'tca' => 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_tca.xlf',
        'core' => 'LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf',
        'frontend' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf',
    ];

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
                        --palette--;;general,
                        --palette--;;headers,
                    --div--;' . $ll['tca'] . ':tabs.configuration,
                        pi_flexform,
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
                    --div--;' . $ll['core'] . ':extended',
            ]
        ],
        'columns' => [
            'pi_flexform' => [
                'label' => $ll['tca'] . ':pi_flexform',
                'config' => [
                    'ds' => [
                        '*,' . $extensionName . '_' . $contentElementName => '
                            FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/' . $contentElementName . '.xml',
                    ],
                ],
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
    'bookmarklist'
);
