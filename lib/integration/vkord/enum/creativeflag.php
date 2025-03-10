<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Тип рекламного объявления
 */
class CreativeFlag
{
    /** Социальная реклама */
    const string SOCIAL = 'social';

    /** Нативная реклама */
    const string NATIVE = 'native';

    /**
     * Получить список всех типов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::SOCIAL,
            self::NATIVE,
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
            self::SOCIAL => 'Социальная реклама',
            self::NATIVE => 'Нативная реклама',
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