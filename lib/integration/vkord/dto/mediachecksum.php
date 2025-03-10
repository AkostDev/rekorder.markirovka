<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Информация о контрольной сумме медиафайла
 */
class MediaCheckSum implements JsonSerializable
{
    /** @var string Хеш SHA256 медиафайла */
    private string $sha256;

    /**
     * @param string $sha256 Хеш SHA256 медиафайла
     */
    public function __construct(string $sha256)
    {
        $this->sha256 = $sha256;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self($data['sha256']);
    }

    /**
     * Получить хеш SHA256 медиафайла
     *
     * @return string
     */
    public function getSha256(): string
    {
        return $this->sha256;
    }

    /**
     * Установить хеш SHA256 медиафайла
     *
     * @param string $sha256
     * @return self
     */
    public function setSha256(string $sha256): self
    {
        $this->sha256 = $sha256;
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
            'sha256' => $this->sha256,
        ];
    }
}