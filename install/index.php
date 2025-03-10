<?php

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Bitrix\Main\SystemException;

Loc::loadMessages(__FILE__);

class rekorder_markirovka extends CModule
{
    /** @var string */
    public $MODULE_ID = 'rekorder.markirovka';

    /** @var string */
    public $MODULE_VERSION;

    /** @var string */
    public $MODULE_VERSION_DATE;

    /** @var string */
    public $MODULE_NAME;

    /** @var string */
    public $MODULE_DESCRIPTION;

    /** @var string */
    public $MODULE_GROUP_RIGHTS = 'Y';

    /** @var string */
    public $PARTNER_NAME = 'ООО «ИИС»';

    /** @var string */
    public $PARTNER_URI = 'https://www.iis-it.ru/';

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && isset($arModuleVersion['VERSION'])) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('RM_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('RM_MODULE_DESCRIPTION');
    }

    /**
     * @throws LoaderException
     * @throws SystemException
     */
    public function DoInstall(): bool
    {
        global $APPLICATION;

        if (!$this->isVersionD7()) {
            $APPLICATION->ThrowException(
                Loc::getMessage('RM_INSTALL_ERROR_VERSION')
            );

            return false;
        }

        $this->InstallDB();
        $this->InstallFiles();
        $this->InstallEvents();

        ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    public function DoUninstall(): true
    {
        $this->UnInstallEvents();
        $this->UnInstallFiles();
        $this->UnInstallDB();

        ModuleManager::unRegisterModule($this->MODULE_ID);

        return true;
    }

    /**
     * Установка таблиц БД
     * @throws LoaderException
     * @throws SystemException
     */
    public function InstallDB(): true
    {
        if (Loader::includeModule($this->MODULE_ID)) {
            // Создание таблиц через ORM
            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\AccountTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\ContractTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\CreativeTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\PersonTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\StatusTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\InvoiceTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\MediaTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\PadTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\InvoiceItemTable')->createDbTable();
//            Bitrix\Main\Entity\Base::getInstance('Rekorder\Markirovka\Entity\StatisticsTable')->createDbTable();

            return true;
        }

        // Альтернативный вариант - использование SQL-скрипта
        $connection = Application::getConnection();
        $sqlFile = __DIR__ . '/db/install.sql';

        if (file_exists($sqlFile)) {
            $connection->executeSqlBatch(file_get_contents($sqlFile));
        }

        return true;
    }

    /**
     * @throws SqlQueryException
     * @throws ArgumentNullException
     * @throws ArgumentException
     */
    public function UnInstallDB(): true
    {
        if (Option::get($this->MODULE_ID, 'delete_tables_on_uninstall') === 'Y') {
            $connection = Application::getConnection();

            // Удаление таблиц (с учетом зависимостей)
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_invoice_item');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_statistics');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_invoice');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_media');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_pad');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_creative');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_contract');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_person');
//            $connection->queryExecute('DROP TABLE IF EXISTS ro_status');
            $connection->queryExecute('DROP TABLE IF EXISTS ro_account');
        }

        // Удаление настроек модуля
        Option::delete($this->MODULE_ID);

        return true;
    }

    public function InstallFiles(): true
    {
        CopyDirFiles(
            __DIR__ . '/js',
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/$this->MODULE_ID/",
            true,
            true
        );

        CopyDirFiles(
            __DIR__ . '/tools',
            $_SERVER["DOCUMENT_ROOT"] . "/bitrix/tools/$this->MODULE_ID/",
            true,
            true
        );

        return true;
    }
    public function UnInstallFiles(): true
    {
        DeleteDirFilesEx("/bitrix/js/$this->MODULE_ID/");
        DeleteDirFilesEx("/bitrix/tools/$this->MODULE_ID/");

        return true;
    }

    public function InstallEvents(): true
    {
        RegisterModuleDependences(
            'main',
            'OnBuildGlobalMenu',
            $this->MODULE_ID,
            '\Rekorder\Markirovka\Service\MenuService',
            'onBuildGlobalMenu'
        );

        return true;
    }
    public function UnInstallEvents(): true
    {
        UnRegisterModuleDependences(
            'main',
            'OnBuildGlobalMenu',
            $this->MODULE_ID,
            '\Rekorder\Markirovka\Service\MenuService',
            'onBuildGlobalMenu'
        );

        return true;
    }

    private function isVersionD7(): bool
    {
        return version_compare(ModuleManager::getVersion('main'), '14.00.00') >= 0;
    }
}