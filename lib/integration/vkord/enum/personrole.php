<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Роли контрагента
 */
class PersonRole
{
    /** Рекламодатель */
    const string ADVERTISER = 'advertiser';

    /** Рекламное агентство */
    const string AGENCY = 'agency';

    /** Оператор рекламной системы */
    const string ORS = 'ors';

    /** Издатель, рекламораспространитель */
    const string PUBLISHER = 'publisher';

    /**
     * Получить список всех ролей
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::ADVERTISER,
            self::AGENCY,
            self::ORS,
            self::PUBLISHER,
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
            self::ADVERTISER => 'Рекламодатель',
            self::AGENCY => 'Рекламное агентство',
            self::ORS => 'Оператор рекламной системы',
            self::PUBLISHER => 'Издатель, рекламораспространитель',
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