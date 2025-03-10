<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\PersonType;

/**
 * Реквизиты контрагента
 */
class PersonJuridicalDetails implements JsonSerializable
{
    /** @var string Тип контрагента */
    private string $type;

    /** @var string|null ИНН контрагента */
    private ?string $inn;

    /** @var string|null Абонентский номер мобильного телефона */
    private ?string $phone;

    /** @var string|null Номер карты или расчётного счёта иностранного электронного средства платежа */
    private ?string $foreignEpaymentMethod;

    /** @var string|null Регистрационный номер иностранного юридического лица */
    private ?string $foreignRegistrationNumber;

    /** @var string|null Номер налогоплательщика или его аналог, присвоенный в стране регистрации */
    private ?string $foreignInn;

    /** @var string|null Код страны в цифровом формате ISO 3166 */
    private ?string $foreignOksmCountryCode;

    /**
     * @param string $type Тип контрагента
     * @param string|null $inn ИНН контрагента
     * @param string|null $phone Абонентский номер мобильного телефона
     * @param string|null $foreignEpaymentMethod Номер карты или расчётного счёта
     * @param string|null $foreignRegistrationNumber Регистрационный номер иностранного юридического лица
     * @param string|null $foreignInn Номер налогоплательщика в стране регистрации
     * @param string|null $foreignOksmCountryCode Код страны в цифровом формате ISO 3166
     */
    public function __construct(
        string $type,
        ?string $inn = null,
        ?string $phone = null,
        ?string $foreignEpaymentMethod = null,
        ?string $foreignRegistrationNumber = null,
        ?string $foreignInn = null,
        ?string $foreignOksmCountryCode = null
    ) {
        if (!PersonType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип контрагента: $type");
        }

        $this->type = $type;
        $this->inn = $inn;
        $this->phone = $phone;
        $this->foreignEpaymentMethod = $foreignEpaymentMethod;
        $this->foreignRegistrationNumber = $foreignRegistrationNumber;
        $this->foreignInn = $foreignInn;
        $this->foreignOksmCountryCode = $foreignOksmCountryCode;
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
            $data['inn'] ?? null,
            $data['phone'] ?? null,
            $data['foreign_epayment_method'] ?? null,
            $data['foreign_registration_number'] ?? null,
            $data['foreign_inn'] ?? null,
            $data['foreign_oksm_country_code'] ?? null
        );
    }

    /**
     * Получить тип контрагента
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Установить тип контрагента
     *
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        if (!PersonType::isValid($type)) {
            throw new InvalidArgumentException("Недопустимый тип контрагента: $type");
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Получить ИНН контрагента
     *
     * @return string|null
     */
    public function getInn(): ?string
    {
        return $this->inn;
    }

    /**
     * Установить ИНН контрагента
     *
     * @param string|null $inn
     * @return self
     */
    public function setInn(?string $inn): self
    {
        $this->inn = $inn;
        return $this;
    }

    /**
     * Получить номер телефона
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Установить номер телефона
     *
     * @param string|null $phone
     * @return self
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Получить номер карты иностранного средства платежа
     *
     * @return string|null
     */
    public function getForeignEpaymentMethod(): ?string
    {
        return $this->foreignEpaymentMethod;
    }

    /**
     * Установить номер карты иностранного средства платежа
     *
     * @param string|null $foreignEpaymentMethod
     * @return self
     */
    public function setForeignEpaymentMethod(?string $foreignEpaymentMethod): self
    {
        $this->foreignEpaymentMethod = $foreignEpaymentMethod;
        return $this;
    }

    /**
     * Получить регистрационный номер иностранного юридического лица
     *
     * @return string|null
     */
    public function getForeignRegistrationNumber(): ?string
    {
        return $this->foreignRegistrationNumber;
    }

    /**
     * Установить регистрационный номер иностранного юридического лица
     *
     * @param string|null $foreignRegistrationNumber
     * @return self
     */
    public function setForeignRegistrationNumber(?string $foreignRegistrationNumber): self
    {
        $this->foreignRegistrationNumber = $foreignRegistrationNumber;
        return $this;
    }

    /**
     * Получить номер налогоплательщика в стране регистрации
     *
     * @return string|null
     */
    public function getForeignInn(): ?string
    {
        return $this->foreignInn;
    }

    /**
     * Установить номер налогоплательщика в стране регистрации
     *
     * @param string|null $foreignInn
     * @return self
     */
    public function setForeignInn(?string $foreignInn): self
    {
        $this->foreignInn = $foreignInn;
        return $this;
    }

    /**
     * Получить код страны в формате ISO 3166
     *
     * @return string|null
     */
    public function getForeignOksmCountryCode(): ?string
    {
        return $this->foreignOksmCountryCode;
    }

    /**
     * Установить код страны в формате ISO 3166
     *
     * @param string|null $foreignOksmCountryCode
     * @return self
     */
    public function setForeignOksmCountryCode(?string $foreignOksmCountryCode): self
    {
        $this->foreignOksmCountryCode = $foreignOksmCountryCode;
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
        ];

        if ($this->inn !== null) {
            $result['inn'] = $this->inn;
        }

        if ($this->phone !== null) {
            $result['phone'] = $this->phone;
        }

        if ($this->foreignEpaymentMethod !== null) {
            $result['foreign_epayment_method'] = $this->foreignEpaymentMethod;
        }

        if ($this->foreignRegistrationNumber !== null) {
            $result['foreign_registration_number'] = $this->foreignRegistrationNumber;
        }

        if ($this->foreignInn !== null) {
            $result['foreign_inn'] = $this->foreignInn;
        }

        if ($this->foreignOksmCountryCode !== null) {
            $result['foreign_oksm_country_code'] = $this->foreignOksmCountryCode;
        }

        return $result;
    }
}