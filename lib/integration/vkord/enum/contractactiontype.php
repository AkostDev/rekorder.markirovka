<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Осуществляемые действия (посредничество)
 */
class ContractActionType
{
    /** Распространение рекламы */
    const string DISTRIBUTION = 'distribution';

    /** Заключение договоров */
    const string CONCLUDE = 'conclude';

    /** Коммерческое представительство */
    const string COMMERCIAL = 'commercial';

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
            self::DISTRIBUTION,
            self::CONCLUDE,
            self::COMMERCIAL,
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
            self::DISTRIBUTION => 'Распространение рекламы',
            self::CONCLUDE => 'Заключение договоров',
            self::COMMERCIAL => 'Коммерческое представительство',
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