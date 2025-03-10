<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Типы договоров
 */
class ContractType
{
    /** Договор оказания услуг */
    const string SERVICE = 'service';

    /** Посреднический договор */
    const string MEDIATION = 'mediation';

    /** Дополнительное соглашение */
    const string ADDITIONAL = 'additional';

    /**
     * Получить список всех типов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::SERVICE,
            self::MEDIATION,
            self::ADDITIONAL,
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
            self::SERVICE => 'Договор оказания услуг',
            self::MEDIATION => 'Посреднический договор',
            self::ADDITIONAL => 'Дополнительное соглашение',
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