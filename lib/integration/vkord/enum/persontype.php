<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Тип контрагента
 */
class PersonType
{
    /** Физическое лицо */
    const string PHYSICAL = 'physical';

    /** Юридическое лицо */
    const string JURIDICAL = 'juridical';

    /** Индивидуальный предприниматель */
    const string IP = 'ip';

    /** Иностранное физическое лицо */
    const string FOREIGN_PHYSICAL = 'foreign_physical';

    /** Иностранное юридическое лицо */
    const string FOREIGN_JURIDICAL = 'foreign_juridical';

    /**
     * Получить список всех типов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::PHYSICAL,
            self::JURIDICAL,
            self::IP,
            self::FOREIGN_PHYSICAL,
            self::FOREIGN_JURIDICAL,
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
            self::PHYSICAL => 'Физическое лицо',
            self::JURIDICAL => 'Юридическое лицо',
            self::IP => 'Индивидуальный предприниматель',
            self::FOREIGN_PHYSICAL => 'Иностранное физическое лицо',
            self::FOREIGN_JURIDICAL => 'Иностранное юридическое лицо',
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