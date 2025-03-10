<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Данные креатива в разаллокации
 */
class InvoiceCreative implements JsonSerializable
{
    /** @var string Внешний идентификатор креатива */
    private string $creativeExternalId;

    /** @var array Список рекламных площадок, на которых показан креатив */
    private array $platforms;

    /**
     * @param string $creativeExternalId Внешний идентификатор креатива
     * @param array $platforms Список рекламных площадок
     */
    public function __construct(string $creativeExternalId, array $platforms)
    {
        $this->creativeExternalId = $creativeExternalId;
        $this->platforms = $platforms;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $platforms = [];

        if (isset($data['platforms']) && is_array($data['platforms'])) {
            foreach ($data['platforms'] as $platformData) {
                $platforms[] = InvoicePlatform::fromArray($platformData);
            }
        }

        return new self(
            $data['creative_external_id'],
            $platforms
        );
    }

    /**
     * Получить внешний идентификатор креатива
     *
     * @return string
     */
    public function getCreativeExternalId(): string
    {
        return $this->creativeExternalId;
    }

    /**
     * Установить внешний идентификатор креатива
     *
     * @param string $creativeExternalId
     * @return self
     */
    public function setCreativeExternalId(string $creativeExternalId): self
    {
        $this->creativeExternalId = $creativeExternalId;
        return $this;
    }

    /**
     * Получить список рекламных площадок
     *
     * @return array
     */
    public function getPlatforms(): array
    {
        return $this->platforms;
    }

    /**
     * Установить список рекламных площадок
     *
     * @param array $platforms
     * @return self
     */
    public function setPlatforms(array $platforms): self
    {
        $this->platforms = $platforms;
        return $this;
    }

    /**
     * Добавить рекламную площадку
     *
     * @param InvoicePlatform $platform
     * @return self
     */
    public function addPlatform(InvoicePlatform $platform): self
    {
        $this->platforms[] = $platform;
        return $this;
    }

    /**
     * Сериализовать в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'creative_external_id' => $this->creativeExternalId,
            'platforms' => $this->platforms,
        ];
    }
}