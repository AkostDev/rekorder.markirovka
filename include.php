<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;

try {
    Loader::registerAutoLoadClasses(
        'rekorder.markirovka',
        [
            // Контроллеры
            'Rekorder\Markirovka\Controller\AccountController' => 'lib/controller/accountcontroller.php',
//            'Rekorder\Markirovka\Controller\ContractController' => 'lib/controller/contractcontroller.php',
//            'Rekorder\Markirovka\Controller\CreativeController' => 'lib/controller/creativecontroller.php',
//            'Rekorder\Markirovka\Controller\PersonController' => 'lib/controller/personcontroller.php',

            // Сущности (ORM модели)
            'Rekorder\Markirovka\Entity\Account' => 'lib/entity/account.php',
//            'Rekorder\Markirovka\Entity\Contract' => 'lib/entity/contract.php',
//            'Rekorder\Markirovka\Entity\Creative' => 'lib/entity/creative.php',
//            'Rekorder\Markirovka\Entity\Person' => 'lib/entity/person.php',
//            'Rekorder\Markirovka\Entity\Status' => 'lib/entity/status.php',
//            'Rekorder\Markirovka\Entity\Invoice' => 'lib/entity/invoice.php',
//            'Rekorder\Markirovka\Entity\Media' => 'lib/entity/media.php',
//            'Rekorder\Markirovka\Entity\Pad' => 'lib/entity/pad.php',
//            'Rekorder\Markirovka\Entity\InvoiceItem' => 'lib/entity/invoiceitem.php',
//            'Rekorder\Markirovka\Entity\Statistics' => 'lib/entity/statistics.php',

            // Репозитории
            'Rekorder\Markirovka\Repository\AccountRepository' => 'lib/repository/AccountRepository.php',
//            'Rekorder\Markirovka\Repository\ContractRepository' => 'lib/repository/contractrepository.php',

            // Сервисы
            'Rekorder\Markirovka\Service\AccountService' => 'lib/service/accountservice.php',
//            'Rekorder\Markirovka\Service\ContractService' => 'lib/service/contractservice.php',

            // Обработчики событий
            'Rekorder\Markirovka\Event\AdminMenuHandler' => 'lib/event/adminmenuhandler.php',
        ]
    );
} catch (LoaderException $e) {
}