<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Дополнительная информация об акте
 */
class InvoiceFlag
{
    /** НДС включён в сумму акта */
    const string VAT_INCLUDED = 'vat_included';

    /**
     * Получить список всех флагов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::VAT_INCLUDED,
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
            self::VAT_INCLUDED => 'НДС включён в сумму акта',
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