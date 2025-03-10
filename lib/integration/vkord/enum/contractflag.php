<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Enum;

/**
 * Дополнительная информация о договоре
 */
class ContractFlag
{
    /** НДС включён в сумму договора */
    const string VAT_INCLUDED = 'vat_included';

    /** Подрядчик обязуется вести учёт креативов */
    const string CONTRACTOR_IS_CREATIVES_REPORTER = 'contractor_is_creatives_reporter';

    /** Деньги поступают от подрядчика (исполнителя) клиенту (заказчику) */
    const string AGENT_ACTING_FOR_PUBLISHER = 'agent_acting_for_publisher';

    /**
     * Получить список всех флагов
     *
     * @return array
     */
    public static function getAll(): array
    {
        return [
            self::VAT_INCLUDED,
            self::CONTRACTOR_IS_CREATIVES_REPORTER,
            self::AGENT_ACTING_FOR_PUBLISHER,
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
            self::VAT_INCLUDED => 'НДС включён в сумму договора',
            self::CONTRACTOR_IS_CREATIVES_REPORTER => 'Подрядчик обязуется вести учёт креативов',
            self::AGENT_ACTING_FOR_PUBLISHER => 'Деньги поступают от подрядчика клиенту',
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