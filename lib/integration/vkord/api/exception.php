<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Api;

/**
 * Базовый класс исключений API ВК ОРД
 */
class Exception extends \Exception
{
    /**
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки
     * @param \Exception|null $previous Предыдущее исключение
     */
    public function __construct(string $message = "", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}