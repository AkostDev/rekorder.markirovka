<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;

$module_id = 'rekorder.markirovka';
$moduleAccess = $APPLICATION::GetGroupRight($module_id);

if ($moduleAccess >= 'W' && Loader::includeModule($module_id)) {
    Asset::getInstance()->addString('<script defer src="' . "/bitrix/js/$module_id/alpine-mask.min.js" .'"></script>');
    Asset::getInstance()->addString('<script defer src="' . "/bitrix/js/$module_id/alpine.min.js" .'"></script>');

    $tabControl = new CAdminTabControl('tabControl', [
        [
            'DIV' => 'edit1',
            'TAB' => Loc::getMessage('RM_TAB_MANAGER_TITLE'),
            'ICON' => '',
            'TITLE' => Loc::getMessage('RM_MANAGER_TITLE')
        ],
        [
            'DIV' => 'edit2',
            'TAB' => Loc::getMessage('RM_TAB_ORD_VK_TITLE'),
            'ICON' => '',
            'TITLE' => Loc::getMessage('RM_ORD_VK_TITLE')
        ],
        [
            'DIV' => 'edit3',
            'TAB' => Loc::getMessage('RM_TAB_CONTRAGENT_TITLE'),
            'ICON' => '',
            'TITLE' => Loc::getMessage('RM_CONTRAGENT_TITLE')
        ],
        [
            'DIV' => 'edit4',
            'TAB' => Loc::getMessage('RM_TAB_ACCESS_TITLE'),
            'ICON' => '',
            'TITLE' => Loc::getMessage('RM_ACCESS_TITLE')
        ],
    ]);

    $tabControl->Begin();

    $formActionUrl = $APPLICATION->GetCurPage() . '?mid=' . urlencode($module_id) . '&amp;lang=' . LANGUAGE_ID;
    ?>
    <form action="<?= $formActionUrl ?>" method="post">
        <?= bitrix_sessid_post() ?>
        <?php // TAB 1
        $tabControl->BeginNextTab() ?>
        <tr>
            <td colspan="2">
                <?= Loc::getMessage('RM_MANAGER_TEXT') ?>
                <br>
                <?= BeginNote() ?>
                <?php
                require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/tools/$module_id/request_form.php");
                ?>
                <?= EndNote() ?>
            </td>
        </tr>
        <?php // TAB 2
        $tabControl->BeginNextTab() ?>
        2
        <?php // TAB 3
        $tabControl->BeginNextTab() ?>
        3
        <?php // TAB 4
        $tabControl->BeginNextTab();

        require_once($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/admin/group_rights.php');

        $tabControl->Buttons();
        ?>
        <input
                type="submit"
                name="Update"
                value="<?= Loc::getMessage('MAIN_SAVE') ?>"
                title="<?= Loc::getMessage('MAIN_OPT_SAVE_TITLE') ?>"
                class="adm-btn-save"
        >
        <?php $tabControl->End() ?>
    </form>
<?php }