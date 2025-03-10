<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use InvalidArgumentException;
use JsonSerializable;
use Rekorder\Markirovka\Integration\VkOrd\Enum\CreativePayType;
use Rekorder\Markirovka\Integration\VkOrd\Enum\CreativeForm;
use Rekorder\Markirovka\Integration\VkOrd\Enum\CreativeFlag;

/**
 * Данные креатива
 */
class Creative implements JsonSerializable
{
    /** @var string Модель оплаты показа креатива */
    private string $payType;

    /** @var string Форма распространения креатива */
    private string $form;

    /** @var string|null Внешний идентификатор контрагента, для которого создается креатив */
    private ?string $personExternalId;

    /** @var string|null Внешний идентификатор изначального договора, для которого создается креатив */
    private ?string $contractExternalId;

    /** @var array|null Список кодов ОКВЭД креатива */
    private ?array $okveds;

    /** @var array|null Список кодов ККТУ креатива */
    private ?array $kktus;

    /** @var string|null Название креатива */
    private ?string $name;

    /** @var string|null Бренд рекламируемых товаров или услуг */
    private ?string $brand;

    /** @var string|null Вид рекламируемых товаров или услуг */
    private ?string $category;

    /** @var string|null Дополнительное описание рекламируемых товаров или услуг */
    private ?string $description;

    /** @var string|null Описание целевой аудитории креатива */
    private ?string $targeting;

    /** @var array Список URL-адресов креатива */
    private array $targetUrls = [];

    /** @var array Список текстов креатива */
    private array $texts = [];

    /** @var array Список внешних идентификаторов медиафайлов, используемых в креативе */
    private array $mediaExternalIds = [];

    /** @var array Информация о том, что креатив относится к особому типу рекламного объявления */
    private array $flags = [];

    /** @var string|null Дата и время создания креатива */
    private ?string $createDate;

    /** @var string|null Токен маркировки креатива */
    private ?string $erid;

    /**
     * @param string $payType Модель оплаты показа креатива
     * @param string $form Форма распространения креатива
     * @param string|null $personExternalId Внешний идентификатор контрагента
     * @param string|null $contractExternalId Внешний идентификатор договора
     * @param array|null $okveds Список кодов ОКВЭД креатива
     * @param array|null $kktus Список кодов ККТУ креатива
     * @param string|null $name Название креатива
     * @param string|null $brand Бренд рекламируемых товаров или услуг
     * @param string|null $category Вид рекламируемых товаров или услуг
     * @param string|null $description Дополнительное описание рекламируемых товаров или услуг
     * @param string|null $targeting Описание целевой аудитории креатива
     * @param array $targetUrls Список URL-адресов креатива
     * @param array $texts Список текстов креатива
     * @param array $mediaExternalIds Список внешних идентификаторов медиафайлов
     * @param array $flags Информация о том, что креатив относится к особому типу рекламного объявления
     * @param string|null $createDate Дата и время создания креатива
     * @param string|null $erid Токен маркировки креатива
     */
    public function __construct(
        string $payType,
        string $form,
        ?string $personExternalId = null,
        ?string $contractExternalId = null,
        ?array $okveds = null,
        ?array $kktus = null,
        ?string $name = null,
        ?string $brand = null,
        ?string $category = null,
        ?string $description = null,
        ?string $targeting = null,
        array $targetUrls = [],
        array $texts = [],
        array $mediaExternalIds = [],
        array $flags = [],
        ?string $createDate = null,
        ?string $erid = null
    ) {
        if (!CreativePayType::isValid($payType)) {
            throw new InvalidArgumentException("Недопустимая модель оплаты показа креатива: $payType");
        }

        if (!CreativeForm::isValid($form)) {
            throw new InvalidArgumentException("Недопустимая форма распространения креатива: $form");
        }

        if ($personExternalId === null && $contractExternalId === null) {
            throw new InvalidArgumentException("Необходимо указать либо personExternalId, либо contractExternalId");
        }

        if ($personExternalId !== null && $contractExternalId !== null) {
            throw new InvalidArgumentException("Нельзя указывать одновременно personExternalId и contractExternalId");
        }

        foreach ($flags as $flag) {
            if (!CreativeFlag::isValid($flag)) {
                throw new InvalidArgumentException("Недопустимый флаг креатива: $flag");
            }
        }

        $this->payType = $payType;
        $this->form = $form;
        $this->personExternalId = $personExternalId;
        $this->contractExternalId = $contractExternalId;
        $this->okveds = $okveds;
        $this->kktus = $kktus;
        $this->name = $name;
        $this->brand = $brand;
        $this->category = $category;
        $this->description = $description;
        $this->targeting = $targeting;
        $this->targetUrls = $targetUrls;
        $this->texts = $texts;
        $this->mediaExternalIds = $mediaExternalIds;
        $this->flags = $flags;
        $this->createDate = $createDate;
        $this->erid = $erid;
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
            $data['pay_type'],
            $data['form'],
            $data['person_external_id'] ?? null,
            $data['contract_external_id'] ?? null,
            $data['okveds'] ?? null,
            $data['kktus'] ?? null,
            $data['name'] ?? null,
            $data['brand'] ?? null,
            $data['category'] ?? null,
            $data['description'] ?? null,
            $data['targeting'] ?? null,
            $data['target_urls'] ?? [],
            $data['texts'] ?? [],
            $data['media_external_ids'] ?? [],
            $data['flags'] ?? [],
            $data['create_date'] ?? null,
            $data['erid'] ?? null
        );
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
     * Получить форму распространения креатива
     *
     * @return string
     */
    public function getForm(): string
    {
        return $this->form;
    }

    /**
     * Установить форму распространения креатива
     *
     * @param string $form
     * @return self
     */
    public function setForm(string $form): self
    {
        if (!CreativeForm::isValid($form)) {
            throw new InvalidArgumentException("Недопустимая форма распространения креатива: $form");
        }

        $this->form = $form;
        return $this;
    }

    /**
     * Получить внешний идентификатор контрагента
     *
     * @return string|null
     */
    public function getPersonExternalId(): ?string
    {
        return $this->personExternalId;
    }

    /**
     * Установить внешний идентификатор контрагента
     *
     * @param string|null $personExternalId
     * @return self
     */
    public function setPersonExternalId(?string $personExternalId): self
    {
        if ($personExternalId !== null && $this->contractExternalId !== null) {
            throw new InvalidArgumentException("Нельзя указывать одновременно personExternalId и contractExternalId");
        }

        $this->personExternalId = $personExternalId;
        return $this;
    }

    /**
     * Получить внешний идентификатор договора
     *
     * @return string|null
     */
    public function getContractExternalId(): ?string
    {
        return $this->contractExternalId;
    }

    /**
     * Установить внешний идентификатор договора
     *
     * @param string|null $contractExternalId
     * @return self
     */
    public function setContractExternalId(?string $contractExternalId): self
    {
        if ($contractExternalId !== null && $this->personExternalId !== null) {
            throw new InvalidArgumentException("Нельзя указывать одновременно personExternalId и contractExternalId");
        }

        $this->contractExternalId = $contractExternalId;
        return $this;
    }

    /**
     * Получить список кодов ОКВЭД креатива
     *
     * @return array|null
     */
    public function getOkveds(): ?array
    {
        return $this->okveds;
    }

    /**
     * Установить список кодов ОКВЭД креатива
     *
     * @param array|null $okveds
     * @return self
     */
    public function setOkveds(?array $okveds): self
    {
        $this->okveds = $okveds;
        return $this;
    }

    /**
     * Получить список кодов ККТУ креатива
     *
     * @return array|null
     */
    public function getKktus(): ?array
    {
        return $this->kktus;
    }

    /**
     * Установить список кодов ККТУ креатива
     *
     * @param array|null $kktus
     * @return self
     */
    public function setKktus(?array $kktus): self
    {
        $this->kktus = $kktus;
        return $this;
    }

    /**
     * Получить название креатива
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Установить название креатива
     *
     * @param string|null $name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Получить бренд рекламируемых товаров или услуг
     *
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * Установить бренд рекламируемых товаров или услуг
     *
     * @param string|null $brand
     * @return self
     */
    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * Получить вид рекламируемых товаров или услуг
     *
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * Установить вид рекламируемых товаров или услуг
     *
     * @param string|null $category
     * @return self
     */
    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Получить дополнительное описание товаров или услуг
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Установить дополнительное описание товаров или услуг
     *
     * @param string|null $description
     * @return self
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Получить описание целевой аудитории креатива
     *
     * @return string|null
     */
    public function getTargeting(): ?string
    {
        return $this->targeting;
    }

    /**
     * Установить описание целевой аудитории креатива
     *
     * @param string|null $targeting
     * @return self
     */
    public function setTargeting(?string $targeting): self
    {
        $this->targeting = $targeting;
        return $this;
    }

    /**
     * Получить список URL-адресов креатива
     *
     * @return array
     */
    public function getTargetUrls(): array
    {
        return $this->targetUrls;
    }

    /**
     * Установить список URL-адресов креатива
     *
     * @param array $targetUrls
     * @return self
     */
    public function setTargetUrls(array $targetUrls): self
    {
        $this->targetUrls = $targetUrls;
        return $this;
    }

    /**
     * Добавить URL-адрес креатива
     *
     * @param string $url
     * @return self
     */
    public function addTargetUrl(string $url): self
    {
        if (!in_array($url, $this->targetUrls)) {
            $this->targetUrls[] = $url;
        }
        return $this;
    }

    /**
     * Получить список текстов креатива
     *
     * @return array
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    /**
     * Установить список текстов креатива
     *
     * @param array $texts
     * @return self
     */
    public function setTexts(array $texts): self
    {
        $this->texts = $texts;
        return $this;
    }

    /**
     * Добавить текст креатива
     *
     * @param string $text
     * @return self
     */
    public function addText(string $text): self
    {
        if (!in_array($text, $this->texts)) {
            $this->texts[] = $text;
        }
        return $this;
    }

    /**
     * Получить список внешних идентификаторов медиафайлов
     *
     * @return array
     */
    public function getMediaExternalIds(): array
    {
        return $this->mediaExternalIds;
    }

    /**
     * Установить список внешних идентификаторов медиафайлов
     *
     * @param array $mediaExternalIds
     * @return self
     */
    public function setMediaExternalIds(array $mediaExternalIds): self
    {
        $this->mediaExternalIds = $mediaExternalIds;
        return $this;
    }

    /**
     * Добавить внешний идентификатор медиафайла
     *
     * @param string $mediaExternalId
     * @return self
     */
    public function addMediaExternalId(string $mediaExternalId): self
    {
        if (!in_array($mediaExternalId, $this->mediaExternalIds)) {
            $this->mediaExternalIds[] = $mediaExternalId;
        }
        return $this;
    }

    /**
     * Получить флаги креатива
     *
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }

    /**
     * Установить флаги креатива
     *
     * @param array $flags
     * @return self
     */
    public function setFlags(array $flags): self
    {
        foreach ($flags as $flag) {
            if (!CreativeFlag::isValid($flag)) {
                throw new InvalidArgumentException("Недопустимый флаг креатива: $flag");
            }
        }

        $this->flags = $flags;
        return $this;
    }

    /**
     * Добавить флаг креатива
     *
     * @param string $flag
     * @return self
     */
    public function addFlag(string $flag): self
    {
        if (!CreativeFlag::isValid($flag)) {
            throw new InvalidArgumentException("Недопустимый флаг креатива: $flag");
        }

        if (!in_array($flag, $this->flags)) {
            $this->flags[] = $flag;
        }
        return $this;
    }

    /**
     * Получить дату и время создания креатива
     *
     * @return string|null
     */
    public function getCreateDate(): ?string
    {
        return $this->createDate;
    }

    /**
     * Установить дату и время создания креатива
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
     * Получить токен маркировки креатива
     *
     * @return string|null
     */
    public function getErid(): ?string
    {
        return $this->erid;
    }

    /**
     * Установить токен маркировки креатива
     *
     * @param string|null $erid
     * @return self
     */
    public function setErid(?string $erid): self
    {
        $this->erid = $erid;
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
            'pay_type' => $this->payType,
            'form' => $this->form,
            'target_urls' => $this->targetUrls,
            'texts' => $this->texts,
            'media_external_ids' => $this->mediaExternalIds,
            'flags' => $this->flags,
        ];

        if ($this->personExternalId !== null) {
            $result['person_external_id'] = $this->personExternalId;
        }

        if ($this->contractExternalId !== null) {
            $result['contract_external_id'] = $this->contractExternalId;
        }

        if ($this->okveds !== null) {
            $result['okveds'] = $this->okveds;
        }

        if ($this->kktus !== null) {
            $result['kktus'] = $this->kktus;
        }

        if ($this->name !== null) {
            $result['name'] = $this->name;
        }

        if ($this->brand !== null) {
            $result['brand'] = $this->brand;
        }

        if ($this->category !== null) {
            $result['category'] = $this->category;
        }

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        if ($this->targeting !== null) {
            $result['targeting'] = $this->targeting;
        }

        if ($this->createDate !== null) {
            $result['create_date'] = $this->createDate;
        }

        if ($this->erid !== null) {
            $result['erid'] = $this->erid;
        }

        return $result;
    }
}