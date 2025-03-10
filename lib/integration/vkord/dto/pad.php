<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\PadType;

/**
 * Данные рекламной площадки
 */
class Pad implements JsonSerializable
{
    /** @var string Внешний идентификатор контрагента, связанного с рекламной площадкой */
    private string $personExternalId;

    /** @var bool Информация о том, является ли контрагент владельцем рекламной площадки */
    private bool $isOwner;

    /** @var string Тип рекламной площадки */
    private string $type;

    /** @var string Название рекламной площадки */
    private string $name;

    /** @var string|null URL-адрес рекламной площадки */
    private ?string $url;

    /** @var string|null Дата и время создания рекламной площадки в формате ISO 8601 */
    private ?string $createDate;

    /**
     * @param string $personExternalId Внешний идентификатор контрагента
     * @param bool $isOwner Является ли контрагент владельцем площадки
     * @param string $type Тип рекламной площадки
     * @param string $name Название рекламной площадки
     * @param string|null $url URL-адрес рекламной площадки
     * @param string|null $createDate Дата и время создания рекламной площадки
     */
    public function __construct(
        string $personExternalId,
        bool $isOwner,
        string $type,
        string $name,
        ?string $url = null,
        ?string $createDate = null
    ) {
        if (!PadType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип рекламной площадки: $type");
        }

        $this->personExternalId = $personExternalId;
        $this->isOwner = $isOwner;
        $this->type = $type;
        $this->name = $name;
        $this->url = $url;
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
            $data['person_external_id'],
            $data['is_owner'],
            $data['type'],
            $data['name'],
            $data['url'] ?? null,
            $data['create_date'] ?? null
        );
    }

    /**
     * Получить внешний идентификатор контрагента
     *
     * @return string
     */
    public function getPersonExternalId(): string
    {
        return $this->personExternalId;
    }

    /**
     * Установить внешний идентификатор контрагента
     *
     * @param string $personExternalId
     * @return self
     */
    public function setPersonExternalId(string $personExternalId): self
    {
        $this->personExternalId = $personExternalId;
        return $this;
    }

    /**
     * Проверить, является ли контрагент владельцем площадки
     *
     * @return bool
     */
    public function isOwner(): bool
    {
        return $this->isOwner;
    }

    /**
     * Установить, является ли контрагент владельцем площадки
     *
     * @param bool $isOwner
     * @return self
     */
    public function setIsOwner(bool $isOwner): self
    {
        $this->isOwner = $isOwner;
        return $this;
    }

    /**
     * Получить тип рекламной площадки
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Установить тип рекламной площадки
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        if (!PadType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип рекламной площадки: $type");
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Получить название рекламной площадки
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Установить название рекламной площадки
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Получить URL-адрес рекламной площадки
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Установить URL-адрес рекламной площадки
     *
     * @param string|null $url
     * @return self
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Получить дату и время создания рекламной площадки
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Установить дату и время создания рекламной площадки
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
            'person_external_id' => $this->personExternalId,
            'is_owner' => $this->isOwner,
            'type' => $this->type,
            'name' => $this->name,
        ];

        if ($this->url !== null) {
            $result['url'] = $this->url;
        }

        if ($this->createDate !== null) {
            $result['create_date'] = $this->createDate;
        }

        return $result;
    }
}