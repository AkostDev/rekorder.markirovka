<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php');

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

// Проверка прав
if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
}

// Подключение модуля
if (!Loader::includeModule('rekorder.markirovka')) {
    ShowError(Loc::getMessage('REKORDER_MARKIROVKA_MODULE_NOT_INSTALLED'));
    require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php');
    return;
}

// Заголовок страницы
$APPLICATION->SetTitle(Loc::getMessage('REKORDER_MARKIROVKA_ACCOUNTS_TITLE'));

// Подключаем административный интерфейс
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php');

// Фильтр
$oFilter = new CAdminFilter(
    'rekorder_markirovka_accounts_filter',
    [
        'ID',
        'NAME',
        'ACCESS_KEY',
    ]
);
?>

    <form name="find_form" method="get" action="<?= $APPLICATION->GetCurPage() ?>">
        <?php $oFilter->Begin(); ?>
        <tr>
            <td><?= Loc::getMessage('REKORDER_MARKIROVKA_FIELD_ID') ?>:</td>
            <td>
                <input type="text" name="find_id" size="47" value="<?= htmlspecialcharsbx($find_id) ?>">
            </td>
        </tr>
        <tr>
            <td><?= Loc::getMessage('REKORDER_MARKIROVKA_FIELD_NAME') ?>:</td>
            <td>
                <input type="text" name="find_name" size="47" value="<?= htmlspecialcharsbx($find_name) ?>">
            </td>
        </tr>
        <tr>
            <td><?= Loc::getMessage('REKORDER_MARKIROVKA_FIELD_ACCESS_KEY') ?>:</td>
            <td>
                <input type="text" name="find_access_key" size="47" value="<?= htmlspecialcharsbx($find_access_key) ?>">
            </td>
        </tr>
        <?php
        $oFilter->Buttons([
            'table_id' => 'rekorder_markirovka_accounts_list',
            'url' => $APPLICATION->GetCurPage(),
            'form' => 'find_form',
        ]);
        $oFilter->End();
        ?>
    </form>

<?php
// Список аккаунтов
$accountsRepository = new \Rekorder\Markirovka\Repository\AccountRepository();

// Подготовка фильтра
$arFilter = [];
if (!empty($find_id)) {
    $arFilter['ID'] = $find_id;
}
if (!empty($find_name)) {
    $arFilter['%NAME'] = $find_name;
}
if (!empty($find_access_key)) {
    $arFilter['ACCESS_KEY'] = $find_access_key;
}

// Получение списка
try {
    $accounts = $accountsRepository->getList($arFilter);
} catch (Exception $e) {
    ShowError($e->getMessage());
    $accounts = [];
}

// Создаем список
$oList = new CAdminList('rekorder_markirovka_accounts_list');

// Настраиваем список
$oList->AddHeaders([
    ['id' => 'ID', 'content' => 'ID', 'sort' => 'ID', 'default' => true],
    ['id' => 'NAME', 'content' => Loc::getMessage('REKORDER_MARKIROVKA_FIELD_NAME'), 'sort' => 'NAME', 'default' => true],
    ['id' => 'ACCESS_KEY', 'content' => Loc::getMessage('REKORDER_MARKIROVKA_FIELD_ACCESS_KEY'), 'sort' => 'ACCESS_KEY', 'default' => true],
    ['id' => 'DATE_CREATE', 'content' => Loc::getMessage('REKORDER_MARKIROVKA_FIELD_DATE_CREATE'), 'sort' => 'DATE_CREATE', 'default' => true],
    ['id' => 'DATE_UPDATE', 'content' => Loc::getMessage('REKORDER_MARKIROVKA_FIELD_DATE_UPDATE'), 'sort' => 'DATE_UPDATE', 'default' => true],
]);

// Добавляем элементы в список
foreach ($accounts as $account) {
    $row = $oList->AddRow($account['ID'], $account);

    // Настройка строки
    $row->AddViewField('ID', $account['ID']);
    $row->AddViewField('NAME', $account['NAME']);
    $row->AddViewField('ACCESS_KEY', $account['ACCESS_KEY']);
    $row->AddViewField('DATE_CREATE', $account['DATE_CREATE']);
    $row->AddViewField('DATE_UPDATE', $account['DATE_UPDATE']);

    // Добавляем контекстное меню
    $arActions = [];
    $arActions[] = [
        'ICON' => 'edit',
        'TEXT' => Loc::getMessage('REKORDER_MARKIROVKA_ACTION_EDIT'),
        'ACTION' => $oList->ActionRedirect('rekorder_markirovka_account_edit.php?ID=' . $account['ID'] . '&lang=' . LANGUAGE_ID),
        'DEFAULT' => true,
    ];
    $arActions[] = [
        'SEPARATOR' => true,
    ];
    $arActions[] = [
        'ICON' => 'delete',
        'TEXT' => Loc::getMessage('REKORDER_MARKIROVKA_ACTION_DELETE'),
        'ACTION' => "if(confirm('" . Loc::getMessage('REKORDER_MARKIROVKA_ACTION_DELETE_CONFIRM') . "')) " . $oList->ActionDoGroup($account['ID'], 'delete'),
    ];

    $row->AddActions($arActions);
}

// Контекстное меню списка
$aContext = [
    [
        'TEXT' => Loc::getMessage('REKORDER_MARKIROVKA_ADD_ACCOUNT'),
        'LINK' => 'rekorder_markirovka_account_edit.php?lang=' . LANGUAGE_ID,
        'TITLE' => Loc::getMessage('REKORDER_MARKIROVKA_ADD_ACCOUNT_TITLE'),
        'ICON' => 'btn_new',
    ],
];
$oList->AddAdminContextMenu($aContext);

// Отображаем список
$oList->CheckListMode();
$oList->DisplayList();

// Завершаем страницу
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php');