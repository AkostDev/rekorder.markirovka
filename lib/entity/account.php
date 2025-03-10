<?php
namespace Rekorder\Markirovka\Entity;

use Bitrix\Main\ArgumentTypeException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;
use Bitrix\Main\SystemException;

class AccountTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'ro_account';
    }

    /**
     * @throws ArgumentTypeException
     * @throws SystemException
     */
    public static function getMap(): array
    {
        return [
            (new IntegerField('ID'))
                ->configurePrimary()
                ->configureAutocomplete(),

            (new StringField('NAME'))
                ->configureSize(255)
                ->configureNullable()
                ->addValidator(new LengthValidator(null, 255)),

            (new StringField('ACCESS_KEY'))
                ->configureSize(100)
                ->configureRequired()
                ->addValidator(new LengthValidator(10, 100)),

            (new DatetimeField('DATE_CREATE'))
                ->configureDefaultValueNow(),

            (new DatetimeField('DATE_UPDATE'))
                ->configureDefaultValueNow(),
        ];
    }
}