<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Предмет договора
 */
class ContractSubjectType
{
    /** Представительство */
    const string REPRESENTATION = 'representation';

    /** Организация распространения рекламы */
    const string ORG_DISTRIBUTION = 'org_distribution';

    /** Посредничество */
    const string MEDIATION = 'mediation';

    /** Распространение рекламы */
    const string DISTRIBUTION = 'distribution';

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
            self::REPRESENTATION,
            self::ORG_DISTRIBUTION,
            self::MEDIATION,
            self::DISTRIBUTION,
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
            self::REPRESENTATION => 'Представительство',
            self::ORG_DISTRIBUTION => 'Организация распространения рекламы',
            self::MEDIATION => 'Посредничество',
            self::DISTRIBUTION => 'Распространение рекламы',
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