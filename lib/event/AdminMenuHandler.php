<?php

namespace Rekorder\Markirovka\Event;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

/**
 * Обработчик для добавления пунктов меню в админке
 */
class AdminMenuHandler
{
    /**
     * Обработчик события OnBuildGlobalMenu
     *
     * @param array &$aGlobalMenu Глобальное меню
     * @param array &$aModuleMenu Меню модулей
     */
    public static function onBuildGlobalMenu(array &$aGlobalMenu, array &$aModuleMenu): void
    {
        global $APPLICATION;

        if ($APPLICATION->GetGroupRight('rekorder.markirovka') < 'R') {
            return;
        }

        // Помещаем меню модуля в раздел "Сервисы"
        $aMenu = [
            'parent_menu' => 'global_menu_services',
            'section' => 'rekorder_markirovka',
            'sort' => 1000,
            'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_TITLE'),
            'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_TITLE'),
            'icon' => 'rekorder_markirovka_menu_icon',
            'page_icon' => 'rekorder_markirovka_page_icon',
            'items_id' => 'menu_rekorder_markirovka',
            'items' => [
                [
                    'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_ACCOUNTS'),
                    'url' => 'ro_accounts.php?lang=' . LANGUAGE_ID,
//                    'more_url' => [
//                        'rekorder_markirovka_account_edit.php',
//                    ],
                    'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_ACCOUNTS_TITLE'),
                ],
//                [
//                    'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_CONTRACTS'),
//                    'url' => 'rekorder_markirovka_contracts.php?lang=' . LANGUAGE_ID,
//                    'more_url' => [
//                        'rekorder_markirovka_contract_edit.php',
//                    ],
//                    'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_CONTRACTS_TITLE'),
//                ],
//                [
//                    'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_CREATIVES'),
//                    'url' => 'rekorder_markirovka_creatives.php?lang=' . LANGUAGE_ID,
//                    'more_url' => [
//                        'rekorder_markirovka_creative_edit.php',
//                    ],
//                    'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_CREATIVES_TITLE'),
//                ],
//                [
//                    'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_PERSONS'),
//                    'url' => 'rekorder_markirovka_persons.php?lang=' . LANGUAGE_ID,
//                    'more_url' => [
//                        'rekorder_markirovka_person_edit.php',
//                    ],
//                    'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_PERSONS_TITLE'),
//                ],
//                [
//                    'text' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_SETTINGS'),
//                    'url' => 'settings.php?lang=' . LANGUAGE_ID . '&mid=rekorder.markirovka',
//                    'title' => Loc::getMessage('REKORDER_MARKIROVKA_MENU_SETTINGS_TITLE'),
//                ],
            ],
        ];

        $aModuleMenu[] = $aMenu;
    }
}