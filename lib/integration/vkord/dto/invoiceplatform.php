<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\CreativePayType;

/**
 * Информация о рекламных площадках
 */
class InvoicePlatform implements JsonSerializable
{
    /** @var string Внешний идентификатор рекламной площадки */
    private string $padExternalId;

    /** @var int Количество показов креатива на рекламной площадке */
    private int $showsCount;

    /** @var int Оплаченное количество показов креатива на рекламной площадке */
    private int $invoiceShowsCount;

    /** @var string Сумма, потраченная на показ креатива на рекламной площадке, в рублях */
    private string $amount;

    /** @var string Стоимость в рублях одного целевого действия креатива на рекламной площадке */
    private string $amountPerEvent;

    /** @var string Запланированная дата начала рекламной кампании в формате YYYY-MM-DD */
    private string $dateStartPlanned;

    /** @var string Запланированная дата завершения рекламной кампании в формате YYYY-MM-DD */
    private string $dateEndPlanned;

    /** @var string Фактическая дата начала рекламной кампании в формате YYYY-MM-DD */
    private string $dateStartActual;

    /** @var string Фактическая дата завершения рекламной кампании в формате YYYY-MM-DD */
    private string $dateEndActual;

    /** @var string Модель оплаты показа креатива */
    private string $payType;

    /** @var array|null Дополнительная информация об акте */
    private ?array $flags;

    /**
     * @param string $padExternalId Внешний идентификатор рекламной площадки
     * @param int $showsCount Количество показов креатива на рекламной площадке
     * @param int $invoiceShowsCount Оплаченное количество показов креатива на рекламной площадке
     * @param string $amount Сумма, потраченная на показ креатива на рекламной площадке
     * @param string $amountPerEvent Стоимость одного целевого действия креатива
     * @param string $dateStartPlanned Запланированная дата начала рекламной кампании
     * @param string $dateEndPlanned Запланированная дата завершения рекламной кампании
     * @param string $dateStartActual Фактическая дата начала рекламной кампании
     * @param string $dateEndActual Фактическая дата завершения рекламной кампании
     * @param string $payType Модель оплаты показа креатива
     * @param array|null $flags Дополнительная информация об акте
     */
    public function __construct(
        string $padExternalId,
        int $showsCount,
        int $invoiceShowsCount,
        string $amount,
        string $amountPerEvent,
        string $dateStartPlanned,
        string $dateEndPlanned,
        string $dateStartActual,
        string $dateEndActual,
        string $payType,
        ?array $flags = null
    ) {
        if (!CreativePayType::isValid($payType)) {
            throw new InvalidArgumentException("Недопустимая модель оплаты показа креатива: $payType");
        }

        $this->padExternalId = $padExternalId;
        $this->showsCount = $showsCount;
        $this->invoiceShowsCount = $invoiceShowsCount;
        $this->amount = $amount;
        $this->amountPerEvent = $amountPerEvent;
        $this->dateStartPlanned = $dateStartPlanned;
        $this->dateEndPlanned = $dateEndPlanned;
        $this->dateStartActual = $dateStartActual;
        $this->dateEndActual = $dateEndActual;
        $this->payType = $payType;
        $this->flags = $flags;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['pad_external_id'],
            $data['shows_count'],
            $data['invoice_shows_count'],
            $data['amount'],
            $data['amount_per_event'],
            $data['date_start_planned'],
            $data['date_end_planned'],
            $data['date_start_actual'],
            $data['date_end_actual'],
            $data['pay_type'],
            $data['flags'] ?? null
        );
    }

    /**
     * Получить внешний идентификатор рекламной площадки
     *
     * @return string
     */
    public function getPadExternalId(): string
    {
        return $this->padExternalId;
    }

    /**
     * Установить внешний идентификатор рекламной площадки
     *
     * @param string $padExternalId
     * @return self
     */
    public function setPadExternalId(string $padExternalId): self
    {
        $this->padExternalId = $padExternalId;
        return $this;
    }

    /**
     * Получить количество показов креатива на рекламной площадке
     *
     * @return int
     */
    public function getShowsCount(): int
    {
        return $this->showsCount;
    }

    /**
     * Установить количество показов креатива на рекламной площадке
     *
     * @param int $showsCount
     * @return self
     */
    public function setShowsCount(int $showsCount): self
    {
        $this->showsCount = $showsCount;
        return $this;
    }

    /**
     * Получить оплаченное количество показов креатива на рекламной площадке
     *
     * @return int
     */
    public function getInvoiceShowsCount(): int
    {
        return $this->invoiceShowsCount;
    }

    /**
     * Установить оплаченное количество показов креатива на рекламной площадке
     *
     * @param int $invoiceShowsCount
     * @return self
     */
    public function setInvoiceShowsCount(int $invoiceShowsCount): self
    {
        $this->invoiceShowsCount = $invoiceShowsCount;
        return $this;
    }

    /**
     * Получить сумму, потраченную на показ креатива на рекламной площадке
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Установить сумму, потраченную на показ креатива на рекламной площадке
     *
     * @param string $amount
     * @return self
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Получить стоимость одного целевого действия креатива
     *
     * @return string
     */
    public function getAmountPerEvent(): string
    {
        return $this->amountPerEvent;
    }

    /**
     * Установить стоимость одного целевого действия креатива
     *
     * @param string $amountPerEvent
     * @return self
     */
    public function setAmountPerEvent(string $amountPerEvent): self
    {
        $this->amountPerEvent = $amountPerEvent;
        return $this;
    }

    /**
     * Получить запланированную дату начала рекламной кампании
     *
     * @return string
     */
    public function getDateStartPlanned(): string
    {
        return $this->dateStartPlanned;
    }

    /**
     * Установить запланированную дату начала рекламной кампании
     *
     * @param string $dateStartPlanned
     * @return self
     */
    public function setDateStartPlanned(string $dateStartPlanned): self
    {
        $this->dateStartPlanned = $dateStartPlanned;
        return $this;
    }

    /**
     * Получить запланированную дату завершения рекламной кампании
     *
     * @return string
     */
    public function getDateEndPlanned(): string
    {
        return $this->dateEndPlanned;
    }

    /**
     * Установить запланированную дату завершения рекламной кампании
     *
     * @param string $dateEndPlanned
     * @return self
     */
    public function setDateEndPlanned(string $dateEndPlanned): self
    {
        $this->dateEndPlanned = $dateEndPlanned;
        return $this;
    }

    /**
     * Получить фактическую дату начала рекламной кампании
     *
     * @return string
     */
    public function getDateStartActual(): string
    {
        return $this->dateStartActual;
    }

    /**
     * Установить фактическую дату начала рекламной кампании
     *
     * @param string $dateStartActual
     * @return self
     */
    public function setDateStartActual(string $dateStartActual): self
    {
        $this->dateStartActual = $dateStartActual;
        return $this;
    }

    /**
     * Получить фактическую дату завершения рекламной кампании
     *
     * @return string
     */
    public function getDateEndActual(): string
    {
        return $this->dateEndActual;
    }

    /**
     * Установить фактическую дату завершения рекламной кампании
     *
     * @param string $dateEndActual
     * @return self
     */
    public function setDateEndActual(string $dateEndActual): self
    {
        $this->dateEndActual = $dateEndActual;
        return $this;
    }

    /**
     * Получить модель оплаты показа креатива
     *
     * @return string
     */
    public function getPayType(): string
    {
        return $this->payType;
    }

    /**
     * Установить модель оплаты показа креатива
     *
     * @param string $payType
     * @return self
     */
    public function setPayType(string $payType): self
    {
        if (!CreativePayType::isValid($payType)) {
            throw new InvalidArgumentException("Недопустимая модель оплаты показа креатива: $payType");
        }

        $this->payType = $payType;
        return $this;
    }

    /**
     * Получить дополнительную информацию об акте
     *
     * @return array|null
     */
    public function getFlags(): ?array
    {
        return $this->flags;
    }

    /**
     * Установить дополнительную информацию об акте
     *
     * @param array|null $flags
     * @return self
     */
    public function setFlags(?array $flags): self
    {
        $this->flags = $flags;
        return $this;
    }

    /**
     * Сериализовать в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [
            'pad_external_id' => $this->padExternalId,
            'shows_count' => $this->showsCount,
            'invoice_shows_count' => $this->invoiceShowsCount,
            'amount' => $this->amount,
            'amount_per_event' => $this->amountPerEvent,
            'date_start_planned' => $this->dateStartPlanned,
            'date_end_planned' => $this->dateEndPlanned,
            'date_start_actual' => $this->dateStartActual,
            'date_end_actual' => $this->dateEndActual,
            'pay_type' => $this->payType,
        ];

        if ($this->flags !== null) {
            $result['flags'] = $this->flags;
        }

        return $result;
    }
}