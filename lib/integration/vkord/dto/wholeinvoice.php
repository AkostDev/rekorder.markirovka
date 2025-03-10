<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\PersonRole;
use Rekorder\Markirovka\Integration\VkOrd\Enum\InvoiceFlag;

/**
 * Данные акта с полной информацией о разаллокации
 */
class WholeInvoice implements JsonSerializable
{
    /** @var string Внешний идентификатор договора, к которому добавляется акт */
    private string $contractExternalId;

    /** @var string Дата выставления акта в формате YYYY-MM-DD */
    private string $date;

    /** @var string Дата начала периода акта в формате YYYY-MM-DD */
    private string $dateStart;

    /** @var string Дата окончания периода акта в формате YYYY-MM-DD */
    private string $dateEnd;

    /** @var string Положительная сумма акта в рублях с копейками */
    private string $amount;

    /** @var string Роль контрагента клиента (заказчика) */
    private string $clientRole;

    /** @var string Роль контрагента подрядчика (исполнителя) */
    private string $contractorRole;

    /** @var string|null Серийный номер акта */
    private ?string $serial;

    /** @var array|null Дополнительная информация об акте */
    private ?array $flags;

    /** @var array|null Список изначальных договоров в разаллокации */
    private ?array $items;

    /**
     * @param string $contractExternalId Внешний идентификатор договора
     * @param string $date Дата выставления акта в формате YYYY-MM-DD
     * @param string $dateStart Дата начала периода акта в формате YYYY-MM-DD
     * @param string $dateEnd Дата окончания периода акта в формате YYYY-MM-DD
     * @param string $amount Положительная сумма акта в рублях с копейками
     * @param string $clientRole Роль контрагента клиента (заказчика)
     * @param string $contractorRole Роль контрагента подрядчика (исполнителя)
     * @param string|null $serial Серийный номер акта
     * @param array|null $flags Дополнительная информация об акте
     * @param array|null $items Список изначальных договоров в разаллокации
     */
    public function __construct(
        string $contractExternalId,
        string $date,
        string $dateStart,
        string $dateEnd,
        string $amount,
        string $clientRole,
        string $contractorRole,
        ?string $serial = null,
        ?array $flags = null,
        ?array $items = null
    ) {
        if (!PersonRole::isValid($clientRole)) {
            throw new InvalidArgumentException("Недопустимая роль клиента: $clientRole");
        }

        if (!PersonRole::isValid($contractorRole)) {
            throw new InvalidArgumentException("Недопустимая роль подрядчика: $contractorRole");
        }

        if ($flags !== null) {
            foreach ($flags as $flag) {
                if (!InvoiceFlag::isValid($flag)) {
                    throw new InvalidArgumentException("Недопустимый флаг акта: $flag");
                }
            }
        }

        $this->contractExternalId = $contractExternalId;
        $this->date = $date;
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
        $this->amount = $amount;
        $this->clientRole = $clientRole;
        $this->contractorRole = $contractorRole;
        $this->serial = $serial;
        $this->flags = $flags;
        $this->items = $items;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $items = null;

        if (isset($data['items']) && is_array($data['items'])) {
            $items = [];
            foreach ($data['items'] as $itemData) {
                $items[] = InvoiceContract::fromArray($itemData);
            }
        }

        return new self(
            $data['contract_external_id'],
            $data['date'],
            $data['date_start'],
            $data['date_end'],
            $data['amount'],
            $data['client_role'],
            $data['contractor_role'],
            $data['serial'] ?? null,
            $data['flags'] ?? null,
            $items
        );
    }

    /**
     * Получить внешний идентификатор договора
     *
     * @return string
     */
    public function getContractExternalId(): string
    {
        return $this->contractExternalId;
    }

    /**
     * Установить внешний идентификатор договора
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
     * Получить дату выставления акта
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Установить дату выставления акта
     *
     * @param string $date
     * @return self
     */
    public function setDate(string $date): self
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Получить дату начала периода акта
     *
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * Установить дату начала периода акта
     *
     * @param string $dateStart
     * @return self
     */
    public function setDateStart(string $dateStart): self
    {
        $this->dateStart = $dateStart;
        return $this;
    }

    /**
     * Получить дату окончания периода акта
     *
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    /**
     * Установить дату окончания периода акта
     *
     * @param string $dateEnd
     * @return self
     */
    public function setDateEnd(string $dateEnd): self
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * Получить сумму акта
     *
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * Установить сумму акта
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
     * Получить роль клиента
     *
     * @return string
     */
    public function getClientRole(): string
    {
        return $this->clientRole;
    }

    /**
     * Установить роль клиента
     *
     * @param string $clientRole
     * @return self
     */
    public function setClientRole(string $clientRole): self
    {
        if (!PersonRole::isValid($clientRole)) {
            throw new InvalidArgumentException("Недопустимая роль клиента: $clientRole");
        }

        $this->clientRole = $clientRole;
        return $this;
    }

    /**
     * Получить роль подрядчика
     *
     * @return string
     */
    public function getContractorRole(): string
    {
        return $this->contractorRole;
    }

    /**
     * Установить роль подрядчика
     *
     * @param string $contractorRole
     * @return self
     */
    public function setContractorRole(string $contractorRole): self
    {
        if (!PersonRole::isValid($contractorRole)) {
            throw new InvalidArgumentException("Недопустимая роль подрядчика: $contractorRole");
        }

        $this->contractorRole = $contractorRole;
        return $this;
    }

    /**
     * Получить серийный номер акта
     *
     * @return string|null
     */
    public function getSerial(): ?string
    {
        return $this->serial;
    }

    /**
     * Установить серийный номер акта
     *
     * @param string|null $serial
     * @return self
     */
    public function setSerial(?string $serial): self
    {
        $this->serial = $serial;
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
     * Получить список изначальных договоров в разаллокации
     *
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Установить список изначальных договоров в разаллокации
     *
     * @param array|null $items
     * @return self
     */
    public function setItems(?array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Добавить изначальный договор в разаллокацию
     *
     * @param InvoiceContract $item
     * @return self
     */
    public function addItem(InvoiceContract $item): self
    {
        if ($this->items === null) {
            $this->items = [];
        }

        $this->items[] = $item;
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
            'date' => $this->date,
            'date_start' => $this->dateStart,
            'date_end' => $this->dateEnd,
            'amount' => $this->amount,
            'client_role' => $this->clientRole,
            'contractor_role' => $this->contractorRole,
        ];

        if ($this->serial !== null) {
            $result['serial'] = $this->serial;
        }

        if ($this->flags !== null) {
            $result['flags'] = $this->flags;
        }

        if ($this->items !== null) {
            $result['items'] = $this->items;
        }

        return $result;
    }
}