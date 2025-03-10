<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Модель оплаты показа креатива
 */
class CreativePayType
{
    /** Cost Per Action, цена за действие */
    const string CPA = 'cpa';

    /** Cost Per Click, цена за клик */
    const string CPC = 'cpc';

    /** Cost Per Millennium, цена за 1 000 показов */
    const string CPM = 'cpm';

    /** Иное */
    const string OTHER = 'other';

    /**
     * Получить список всех типов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::CPA,
            self::CPC,
            self::CPM,
            self::OTHER,
        ];
    }

    /**
     * Получить список для отображения
     *
     * @return array
     */
    public static function getList(): array
    {
        return [
            self::CPA => 'Cost Per Action (цена за действие)',
            self::CPC => 'Cost Per Click (цена за клик)',
            self::CPM => 'Cost Per Millennium (цена за 1 000 показов)',
            self::OTHER => 'Иное',
        ];
    }

    /**
     * Проверить валидность значения
     *
     * @param string $value
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return in_array($value, self::getAll());
    }
}