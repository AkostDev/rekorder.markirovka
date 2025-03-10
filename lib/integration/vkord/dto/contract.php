<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\ContractType;
use Rekorder\Markirovka\Integration\VkOrd\Enum\ContractSubjectType;
use Rekorder\Markirovka\Integration\VkOrd\Enum\ContractActionType;
use Rekorder\Markirovka\Integration\VkOrd\Enum\ContractFlag;

/**
 * Данные договора
 */
class Contract implements JsonSerializable
{
    /** @var string Тип договора */
    private string $type;

    /** @var string Внешний идентификатор клиента (заказчика) */
    private string $clientExternalId;

    /** @var string Внешний идентификатор подрядчика (исполнителя) */
    private string $contractorExternalId;

    /** @var string Дата заключения договора в формате YYYY-MM-DD */
    private string $date;

    /** @var string Предмет договора */
    private string $subjectType;

    /** @var string|null Серийный номер договора */
    private ?string $serial;

    /** @var string|null Цена договора в рублях с копейками */
    private ?string $amount;

    /** @var string|null Осуществляемые действия (посредничество) */
    private ?string $actionType;

    /** @var array|null Дополнительная информация о договоре */
    private ?array $flags;

    /** @var string|null Внешний идентификатор родительского договора */
    private ?string $parentContractExternalId;

    /** @var string|null Дата окончания договора в формате YYYY-MM-DD */
    private ?string $dateEnd;

    /** @var string|null Комментарий к договору */
    private ?string $comment;

    /** @var string|null Дата и время создания договора в формате ISO 8601 */
    private ?string $createDate;

    /**
     * @param string $type Тип договора
     * @param string $clientExternalId Внешний идентификатор клиента (заказчика)
     * @param string $contractorExternalId Внешний идентификатор подрядчика (исполнителя)
     * @param string $date Дата заключения договора в формате YYYY-MM-DD
     * @param string $subjectType Предмет договора
     * @param string|null $serial Серийный номер договора
     * @param string|null $amount Цена договора в рублях с копейками
     * @param string|null $actionType Осуществляемые действия (посредничество)
     * @param array|null $flags Дополнительная информация о договоре
     * @param string|null $parentContractExternalId Внешний идентификатор родительского договора
     * @param string|null $dateEnd Дата окончания договора в формате YYYY-MM-DD
     * @param string|null $comment Комментарий к договору
     * @param string|null $createDate Дата и время создания договора в формате ISO 8601
     */
    public function __construct(
        string $type,
        string $clientExternalId,
        string $contractorExternalId,
        string $date,
        string $subjectType,
        ?string $serial = null,
        ?string $amount = null,
        ?string $actionType = null,
        ?array $flags = null,
        ?string $parentContractExternalId = null,
        ?string $dateEnd = null,
        ?string $comment = null,
        ?string $createDate = null
    ) {
        if (!ContractType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип договора: $type");
        }

        if (!ContractSubjectType::isValid($subjectType)) {
            throw new InvalidArgumentException("Недопустимый предмет договора: $subjectType");
        }

        if ($actionType !== null && !ContractActionType::isValid($actionType)) {
            throw new InvalidArgumentException("Недопустимый тип действия: $actionType");
        }

        if ($flags !== null) {
            foreach ($flags as $flag) {
                if (!ContractFlag::isValid($flag)) {
                    throw new InvalidArgumentException("Недопустимый флаг договора: $flag");
                }
            }
        }

        $this->type = $type;
        $this->clientExternalId = $clientExternalId;
        $this->contractorExternalId = $contractorExternalId;
        $this->date = $date;
        $this->subjectType = $subjectType;
        $this->serial = $serial;
        $this->amount = $amount;
        $this->actionType = $actionType;
        $this->flags = $flags;
        $this->parentContractExternalId = $parentContractExternalId;
        $this->dateEnd = $dateEnd;
        $this->comment = $comment;
        $this->createDate = $createDate;
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
            $data['type'],
            $data['client_external_id'],
            $data['contractor_external_id'],
            $data['date'],
            $data['subject_type'],
            $data['serial'] ?? null,
            $data['amount'] ?? null,
            $data['action_type'] ?? null,
            $data['flags'] ?? null,
            $data['parent_contract_external_id'] ?? null,
            $data['date_end'] ?? null,
            $data['comment'] ?? null,
            $data['create_date'] ?? null
        );
    }

    /**
     * Получить тип договора
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Установить тип договора
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        if (!ContractType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип договора: $type");
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Получить внешний идентификатор клиента
     *
     * @return string
     */
    public function getClientExternalId(): string
    {
        return $this->clientExternalId;
    }

    /**
     * Установить внешний идентификатор клиента
     *
     * @param string $clientExternalId
     * @return self
     */
    public function setClientExternalId(string $clientExternalId): self
    {
        $this->clientExternalId = $clientExternalId;
        return $this;
    }

    /**
     * Получить внешний идентификатор подрядчика
     *
     * @return string
     */
    public function getContractorExternalId(): string
    {
        return $this->contractorExternalId;
    }

    /**
     * Установить внешний идентификатор подрядчика
     *
     * @param string $contractorExternalId
     * @return self
     */
    public function setContractorExternalId(string $contractorExternalId): self
    {
        $this->contractorExternalId = $contractorExternalId;
        return $this;
    }

    /**
     * Получить дату заключения договора
     *
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * Установить дату заключения договора
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
     * Получить предмет договора
     *
     * @return string
     */
    public function getSubjectType(): string
    {
        return $this->subjectType;
    }

    /**
     * Установить предмет договора
     *
     * @param string $subjectType
     * @return self
     */
    public function setSubjectType(string $subjectType): self
    {
        if (!ContractSubjectType::isValid($subjectType)) {
            throw new InvalidArgumentException("Недопустимый предмет договора: $subjectType");
        }

        $this->subjectType = $subjectType;
        return $this;
    }

    /**
     * Получить серийный номер договора
     *
     * @return string|null
     */
    public function getSerial(): ?string
    {
        return $this->serial;
    }

    /**
     * Установить серийный номер договора
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
     * Получить цену договора
     *
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * Установить цену договора
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
     * Получить тип действия
     *
     * @return string|null
     */
    public function getActionType(): ?string
    {
        return $this->actionType;
    }

    /**
     * Установить тип действия
     *
     * @param string|null $actionType
     * @return self
     */
    public function setActionType(?string $actionType): self
    {
        if ($actionType !== null && !ContractActionType::isValid($actionType)) {
            throw new InvalidArgumentException("Недопустимый тип действия: $actionType");
        }

        $this->actionType = $actionType;
        return $this;
    }

    /**
     * Получить флаги договора
     *
     * @return array|null
     */
    public function getFlags(): ?array
    {
        return $this->flags;
    }

    /**
     * Установить флаги договора
     *
     * @param array|null $flags
     * @return self
     */
    public function setFlags(?array $flags): self
    {
        if ($flags !== null) {
            foreach ($flags as $flag) {
                if (!ContractFlag::isValid($flag)) {
                    throw new InvalidArgumentException("Недопустимый флаг договора: $flag");
                }
            }
        }

        $this->flags = $flags;
        return $this;
    }

    /**
     * Получить идентификатор родительского договора
     *
     * @return string|null
     */
    public function getParentContractExternalId(): ?string
    {
        return $this->parentContractExternalId;
    }

    /**
     * Установить идентификатор родительского договора
     *
     * @param string|null $parentContractExternalId
     * @return self
     */
    public function setParentContractExternalId(?string $parentContractExternalId): self
    {
        $this->parentContractExternalId = $parentContractExternalId;
        return $this;
    }

    /**
     * Получить дату окончания договора
     *
     * @return string|null
     */
    public function getDateEnd(): ?string
    {
        return $this->dateEnd;
    }

    /**
     * Установить дату окончания договора
     *
     * @param string|null $dateEnd
     * @return self
     */
    public function setDateEnd(?string $dateEnd): self
    {
        $this->dateEnd = $dateEnd;
        return $this;
    }

    /**
     * Получить комментарий к договору
     *
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * Установить комментарий к договору
     *
     * @param string|null $comment
     * @return self
     */
    public function setComment(?string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Получить дату создания договора
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Установить дату создания договора
     *
     * @param string|null $createDate
     * @return self
     */
    public function setCreateDate(?string $createDate): self
    {
        $this->createDate = $createDate;
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
            'type' => $this->type,
            'client_external_id' => $this->clientExternalId,
            'contractor_external_id' => $this->contractorExternalId,
            'date' => $this->date,
            'subject_type' => $this->subjectType,
        ];

        if ($this->serial !== null) {
            $result['serial'] = $this->serial;
        }

        if ($this->amount !== null) {
            $result['amount'] = $this->amount;
        }

        if ($this->actionType !== null) {
            $result['action_type'] = $this->actionType;
        }

        if ($this->flags !== null) {
            $result['flags'] = $this->flags;
        }

        if ($this->parentContractExternalId !== null) {
            $result['parent_contract_external_id'] = $this->parentContractExternalId;
        }

        if ($this->dateEnd !== null) {
            $result['date_end'] = $this->dateEnd;
        }

        if ($this->comment !== null) {
            $result['comment'] = $this->comment;
        }

        if ($this->createDate !== null) {
            $result['create_date'] = $this->createDate;
        }

        return $result;
    }
}