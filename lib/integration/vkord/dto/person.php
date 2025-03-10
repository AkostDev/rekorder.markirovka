<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\PersonRole;

/**
 * Данные контрагента
 */
class Person implements JsonSerializable
{
    /** @var string Наименование контрагента */
    private string $name;

    /** @var array Список ролей контрагента */
    private array $roles = [];

    /** @var PersonJuridicalDetails Реквизиты контрагента */
    private PersonJuridicalDetails $juridicalDetails;

    /** @var string|null URL-адрес рекламной системы */
    private ?string $rsUrl;

    /** @var string|null Дата и время создания контрагента в формате ISO 8601 */
    private ?string $createDate;

    /**
     * @param string $name Наименование контрагента
     * @param array $roles Список ролей контрагента
     * @param PersonJuridicalDetails $juridicalDetails Реквизиты контрагента
     * @param string|null $rsUrl URL-адрес рекламной системы
     * @param string|null $createDate Дата и время создания контрагента в формате ISO 8601
     */
    public function __construct(
        string $name,
        array $roles,
        PersonJuridicalDetails $juridicalDetails,
        ?string $rsUrl = null,
        ?string $createDate = null
    ) {
        $this->name = $name;
        $this->setRoles($roles);
        $this->juridicalDetails = $juridicalDetails;
        $this->rsUrl = $rsUrl;
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
            $data['name'],
            $data['roles'],
            PersonJuridicalDetails::fromArray($data['juridical_details']),
            $data['rs_url'] ?? null,
            $data['create_date'] ?? null
        );
    }

    /**
     * Получить наименование контрагента
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Установить наименование контрагента
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
     * Получить список ролей контрагента
     *
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * Установить список ролей контрагента
     *
     * @param array $roles
     * @return self
     */
    public function setRoles(array $roles): self
    {
        // Валидация ролей
        foreach ($roles as $role) {
            if (!PersonRole::isValid($role)) {
                throw new InvalidArgumentException("Недопустимая роль контрагента: $role");
            }
        }

        $this->roles = $roles;
        return $this;
    }

    /**
     * Получить реквизиты контрагента
     *
     * @return PersonJuridicalDetails
     */
    public function getJuridicalDetails(): PersonJuridicalDetails
    {
        return $this->juridicalDetails;
    }

    /**
     * Установить реквизиты контрагента
     *
     * @param PersonJuridicalDetails $juridicalDetails
     * @return self
     */
    public function setJuridicalDetails(PersonJuridicalDetails $juridicalDetails): self
    {
        $this->juridicalDetails = $juridicalDetails;
        return $this;
    }

    /**
     * Получить URL-адрес рекламной системы
     *
     * @return string|null
     */
    public function getRsUrl(): ?string
    {
        return $this->rsUrl;
    }

    /**
     * Установить URL-адрес рекламной системы
     *
     * @param string|null $rsUrl
     * @return self
     */
    public function setRsUrl(?string $rsUrl): self
    {
        $this->rsUrl = $rsUrl;
        return $this;
    }

    /**
     * Получить дату и время создания контрагента
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Установить дату и время создания контрагента
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
            'name' => $this->name,
            'roles' => $this->roles,
            'juridical_details' => $this->juridicalDetails,
        ];

        if ($this->rsUrl !== null) {
            $result['rs_url'] = $this->rsUrl;
        }

        if ($this->createDate !== null) {
            $result['create_date'] = $this->createDate;
        }

        return $result;
    }
}