<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\InvoiceFlag;

/**
 * Данные изначального договора в разаллокации
 */
class InvoiceContract implements JsonSerializable
{
    /** @var string Внешний идентификатор изначального договора */
    private string $contractExternalId;

    /** @var string Положительная сумма разаллокации изначального договора в рублях с копейками */
    private string $amount;

    /** @var array|null Дополнительная информация об акте */
    private ?array $flags;

    /** @var array|null Список креативов изначального договора в разаллокации */
    private ?array $creatives;

    /**
     * @param string $contractExternalId Внешний идентификатор изначального договора
     * @param string $amount Положительная сумма разаллокации изначального договора
     * @param array|null $flags Дополнительная информация об акте
     * @param array|null $creatives Список креативов изначального договора в разаллокации
     */
    public function __construct(
        string $contractExternalId,
        string $amount,
        ?array $flags = null,
        ?array $creatives = null
    ) {
        if ($flags !== null) {
            foreach ($flags as $flag) {
                if (!InvoiceFlag::isValid($flag)) {
                    throw new InvalidArgumentException("Недопустимый флаг акта: $flag");
                }
            }
        }

        $this->contractExternalId = $contractExternalId;
        $this->amount = $amount;
        $this->flags = $flags;
        $this->creatives = $creatives;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $creatives = null;

        if (isset($data['creatives']) && is_array($data['creatives'])) {
            $creatives = [];
            foreach ($data['creatives'] as $creativeData) {
                $creatives[] = InvoiceCreative::fromArray($creativeData);
            }
        }

        return new self(
            $data['contract_external_id'],
            $data['amount'],
            $data['flags'] ?? null,
            $creatives
        );
    }

    /**
     * Получить внешний идентификатор изначального договора
     *
     * @return string
     */
    public function getContractExternalId(): string
    {
        return $this->contractExternalId;
    }

    /**
     * Установить внешний идентификатор изначального договора
     *
     * @param string $contractExternalId
     * @return self
     */
    public function setContractExternalId(string $contractExternalId): self
    {
        $this->contractExternalId = $contractExternalId;
        return $this;
    }

    /**
     * Получить сумму разаллокации
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Установить сумму разаллокации
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
     * Получить флаги акта
     *
     * @return array|null
     */
    public function getFlags(): ?array
    {
        return $this->flags;
    }

    /**
     * Установить флаги акта
     *
     * @param array|null $flags
     * @return self
     */
    public function setFlags(?array $flags): self
    {
        if ($flags !== null) {
            foreach ($flags as $flag) {
                if (!InvoiceFlag::isValid($flag)) {
                    throw new InvalidArgumentException("Недопустимый флаг акта: $flag");
                }
            }
        }

        $this->flags = $flags;
        return $this;
    }

    /**
     * Получить список креативов
     *
     * @return array|null
     */
    public function getCreatives(): ?array
    {
        return $this->creatives;
    }

    /**
     * Установить список креативов
     *
     * @param array|null $creatives
     * @return self
     */
    public function setCreatives(?array $creatives): self
    {
        $this->creatives = $creatives;
        return $this;
    }

    /**
     * Добавить креатив
     *
     * @param InvoiceCreative $creative
     * @return self
     */
    public function addCreative(InvoiceCreative $creative): self
    {
        if ($this->creatives === null) {
            $this->creatives = [];
        }

        $this->creatives[] = $creative;
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
            'contract_external_id' => $this->contractExternalId,
            'amount' => $this->amount,
        ];

        if ($this->flags !== null) {
            $result['flags'] = $this->flags;
        }

        if ($this->creatives !== null) {
            $result['creatives'] = $this->creatives;
        }

        return $result;
    }
}