<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Тип рекламной площадки
 */
class PadType
{
    /** Веб-страница или профиль социальной сети */
    const string WEB = 'web';

    /** Мобильное приложение */
    const string MOBILE_APP = 'mobile_app';

    /**
     * Получить список всех типов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::WEB,
            self::MOBILE_APP,
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
            self::WEB => 'Веб-страница или профиль социальной сети',
            self::MOBILE_APP => 'Мобильное приложение',
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