<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\CreativePayType;

/**
 * Статистика по показам креатива
 */
class Statistic implements JsonSerializable
{
    /** @var string|null Внешний идентификатор статистики */
    private ?string $externalId;

    /** @var string|null Внешний идентификатор креатива */
    private ?string $creativeExternalId;

    /** @var string|null Внешний идентификатор рекламной площадки */
    private ?string $padExternalId;

    /** @var int|null Количество показов креатива на рекламной площадке */
    private ?int $showsCount;

    /** @var string|null Фактическая дата начала рекламной кампании в формате YYYY-MM-DD */
    private ?string $dateStartActual;

    /** @var string|null Фактическая дата завершения рекламной кампании в формате YYYY-MM-DD */
    private ?string $dateEndActual;

    /** @var string|null Запланированная дата начала рекламной кампании в формате YYYY-MM-DD */
    private ?string $dateStartPlanned;

    /** @var string|null Запланированная дата завершения рекламной кампании в формате YYYY-MM-DD */
    private ?string $dateEndPlanned;

    /** @var int|null Оплаченное количество показов креатива на рекламной площадке */
    private ?int $invoiceShowsCount;

    /** @var string|null Неотрицательная сумма, потраченная на показ креатива, в рублях */
    private ?string $amount;

    /** @var string|null Стоимость в рублях одного целевого действия креатива */
    private ?string $amountPerEvent;

    /** @var string|null Модель оплаты показа креатива */
    private ?string $payType;

    /**
     * @param string|null $externalId Внешний идентификатор статистики
     * @param string|null $creativeExternalId Внешний идентификатор креатива
     * @param string|null $padExternalId Внешний идентификатор рекламной площадки
     * @param int|null $showsCount Количество показов креатива на рекламной площадке
     * @param string|null $dateStartActual Фактическая дата начала рекламной кампании
     * @param string|null $dateEndActual Фактическая дата завершения рекламной кампании
     * @param string|null $dateStartPlanned Запланированная дата начала рекламной кампании
     * @param string|null $dateEndPlanned Запланированная дата завершения рекламной кампании
     * @param int|null $invoiceShowsCount Оплаченное количество показов креатива
     * @param string|null $amount Неотрицательная сумма, потраченная на показ креатива
     * @param string|null $amountPerEvent Стоимость одного целевого действия креатива
     * @param string|null $payType Модель оплаты показа креатива
     */
    public function __construct(
        ?string $externalId = null,
        ?string $creativeExternalId = null,
        ?string $padExternalId = null,
        ?int $showsCount = null,
        ?string $dateStartActual = null,
        ?string $dateEndActual = null,
        ?string $dateStartPlanned = null,
        ?string $dateEndPlanned = null,
        ?int $invoiceShowsCount = null,
        ?string $amount = null,
        ?string $amountPerEvent = null,
        ?string $payType = null
    ) {
        if ($payType !== null && !CreativePayType::isValid($payType)) {
            throw new InvalidArgumentException("Недопустимая модель оплаты показа креатива: $payType");
        }

        $this->externalId = $externalId;
        $this->creativeExternalId = $creativeExternalId;
        $this->padExternalId = $padExternalId;
        $this->showsCount = $showsCount;
        $this->dateStartActual = $dateStartActual;
        $this->dateEndActual = $dateEndActual;
        $this->dateStartPlanned = $dateStartPlanned;
        $this->dateEndPlanned = $dateEndPlanned;
        $this->invoiceShowsCount = $invoiceShowsCount;
        $this->amount = $amount;
        $this->amountPerEvent = $amountPerEvent;
        $this->payType = $payType;
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
            $data['external_id'] ?? null,
            $data['creative_external_id'] ?? null,
            $data['pad_external_id'] ?? null,
            $data['shows_count'] ?? null,
            $data['date_start_actual'] ?? null,
            $data['date_end_actual'] ?? null,
            $data['date_start_planned'] ?? null,
            $data['date_end_planned'] ?? null,
            $data['invoice_shows_count'] ?? null,
            $data['amount'] ?? null,
            $data['amount_per_event'] ?? null,
            $data['pay_type'] ?? null
        );
    }

    /**
     * Получить внешний идентификатор статистики
     *
     * @return string|null
     */
    public function getExternalId(): ?string
    {
        return $this->externalId;
    }

    /**
     * Установить внешний идентификатор статистики
     *
     * @param string|null $externalId
     * @return self
     */
    public function setExternalId(?string $externalId): self
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * Получить внешний идентификатор креатива
     *
     * @return string|null
     */
    public function getCreativeExternalId(): ?string
    {
        return $this->creativeExternalId;
    }

    /**
     * Установить внешний идентификатор креатива
     *
     * @param string|null $creativeExternalId
     * @return self
     */
    public function setCreativeExternalId(?string $creativeExternalId): self
    {
        $this->creativeExternalId = $creativeExternalId;
        return $this;
    }

    /**
     * Получить внешний идентификатор рекламной площадки
     *
     * @return string|null
     */
    public function getPadExternalId(): ?string
    {
        return $this->padExternalId;
    }

    /**
     * Установить внешний идентификатор рекламной площадки
     *
     * @param string|null $padExternalId
     * @return self
     */
    public function setPadExternalId(?string $padExternalId): self
    {
        $this->padExternalId = $padExternalId;
        return $this;
    }

    /**
     * Получить количество показов креатива
     *
     * @return int|null
     */
    public function getShowsCount(): ?int
    {
        return $this->showsCount;
    }

    /**
     * Установить количество показов креатива
     *
     * @param int|null $showsCount
     * @return self
     */
    public function setShowsCount(?int $showsCount): self
    {
        $this->showsCount = $showsCount;
        return $this;
    }

    /**
     * Получить фактическую дату начала рекламной кампании
     *
     * @return string|null
     */
    public function getDateStartActual(): ?string
    {
        return $this->dateStartActual;
    }

    /**
     * Установить фактическую дату начала рекламной кампании
     *
     * @param string|null $dateStartActual
     * @return self
     */
    public function setDateStartActual(?string $dateStartActual): self
    {
        $this->dateStartActual = $dateStartActual;
        return $this;
    }

    /**
     * Получить фактическую дату завершения рекламной кампании
     *
     * @return string|null
     */
    public function getDateEndActual(): ?string
    {
        return $this->dateEndActual;
    }

    /**
     * Установить фактическую дату завершения рекламной кампании
     *
     * @param string|null $dateEndActual
     * @return self
     */
    public function setDateEndActual(?string $dateEndActual): self
    {
        $this->dateEndActual = $dateEndActual;
        return $this;
    }

    /**
     * Получить запланированную дату начала рекламной кампании
     *
     * @return string|null
     */
    public function getDateStartPlanned(): ?string
    {
        return $this->dateStartPlanned;
    }

    /**
     * Установить запланированную дату начала рекламной кампании
     *
     * @param string|null $dateStartPlanned
     * @return self
     */
    public function setDateStartPlanned(?string $dateStartPlanned): self
    {
        $this->dateStartPlanned = $dateStartPlanned;
        return $this;
    }

    /**
     * Получить запланированную дату завершения рекламной кампании
     *
     * @return string|null
     */
    public function getDateEndPlanned(): ?string
    {
        return $this->dateEndPlanned;
    }

    /**
     * Установить запланированную дату завершения рекламной кампании
     *
     * @param string|null $dateEndPlanned
     * @return self
     */
    public function setDateEndPlanned(?string $dateEndPlanned): self
    {
        $this->dateEndPlanned = $dateEndPlanned;
        return $this;
    }

    /**
     * Получить оплаченное количество показов креатива
     *
     * @return int|null
     */
    public function getInvoiceShowsCount(): ?int
    {
        return $this->invoiceShowsCount;
    }

    /**
     * Установить оплаченное количество показов креатива
     *
     * @param int|null $invoiceShowsCount
     * @return self
     */
    public function setInvoiceShowsCount(?int $invoiceShowsCount): self
    {
        $this->invoiceShowsCount = $invoiceShowsCount;
        return $this;
    }

    /**
     * Получить сумму, потраченную на показ креатива
     *
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Установить сумму, потраченную на показ креатива
     *
     * @param string|null $amount
     * @return self
     */
    public function setAmount(?string $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Получить стоимость одного целевого действия креатива
     *
     * @return string|null
     */
    public function getAmountPerEvent(): ?string
    {
        return $this->amountPerEvent;
    }

    /**
     * Установить стоимость одного целевого действия креатива
     *
     * @param string|null $amountPerEvent
     * @return self
     */
    public function setAmountPerEvent(?string $amountPerEvent): self
    {
        $this->amountPerEvent = $amountPerEvent;
        return $this;
    }

    /**
     * Получить модель оплаты показа креатива
     *
     * @return string|null
     */
    public function getPayType(): ?string
    {
        return $this->payType;
    }

    /**
     * Установить модель оплаты показа креатива
     *
     * @param string|null $payType
     * @return self
     */
    public function setPayType(?string $payType): self
    {
        if ($payType !== null && !CreativePayType::isValid($payType)) {
            throw new InvalidArgumentException("Недопустимая модель оплаты показа креатива: $payType");
        }

        $this->payType = $payType;
        return $this;
    }

    /**
     * Сериализовать в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [];

        if ($this->externalId !== null) {
            $result['external_id'] = $this->externalId;
        }

        if ($this->creativeExternalId !== null) {
            $result['creative_external_id'] = $this->creativeExternalId;
        }

        if ($this->padExternalId !== null) {
            $result['pad_external_id'] = $this->padExternalId;
        }

        if ($this->showsCount !== null) {
            $result['shows_count'] = $this->showsCount;
        }

        if ($this->dateStartActual !== null) {
            $result['date_start_actual'] = $this->dateStartActual;
        }

        if ($this->dateEndActual !== null) {
            $result['date_end_actual'] = $this->dateEndActual;
        }

        if ($this->dateStartPlanned !== null) {
            $result['date_start_planned'] = $this->dateStartPlanned;
        }

        if ($this->dateEndPlanned !== null) {
            $result['date_end_planned'] = $this->dateEndPlanned;
        }

        if ($this->invoiceShowsCount !== null) {
            $result['invoice_shows_count'] = $this->invoiceShowsCount;
        }

        if ($this->amount !== null) {
            $result['amount'] = $this->amount;
        }

        if ($this->amountPerEvent !== null) {
            $result['amount_per_event'] = $this->amountPerEvent;
        }

        if ($this->payType !== null) {
            $result['pay_type'] = $this->payType;
        }

        return $result;
    }
}