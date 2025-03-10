<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Информация о медиафайле
 */
class Media implements JsonSerializable
{
    /** @var string Имя медиафайла */
    private string $filename;

    /** @var string Хеш SHA256 медиафайла */
    private string $sha256;

    /** @var string Дата и время создания медиафайла в формате ISO 8601 */
    private string $createDate;

    /** @var int Размер медиафайла в байтах */
    private int $size;

    /** @var string MIME тип медиафайла */
    private string $contentType;

    /** @var string|null Описание файла */
    private ?string $description;

    /**
     * @param string $filename Имя медиафайла
     * @param string $sha256 Хеш SHA256 медиафайла
     * @param string $createDate Дата и время создания медиафайла
     * @param int $size Размер медиафайла в байтах
     * @param string $contentType MIME тип медиафайла
     * @param string|null $description Описание файла
     */
    public function __construct(
        string $filename,
        string $sha256,
        string $createDate,
        int $size,
        string $contentType,
        ?string $description = null
    ) {
        $this->filename = $filename;
        $this->sha256 = $sha256;
        $this->createDate = $createDate;
        $this->size = $size;
        $this->contentType = $contentType;
        $this->description = $description;
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
            $data['filename'],
            $data['sha256'],
            $data['create_date'],
            $data['size'],
            $data['content_type'],
            $data['description'] ?? null
        );
    }

    /**
     * Получить имя медиафайла
     *
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * Установить имя медиафайла
     *
     * @param string $filename
     * @return self
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
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
     * Получить дату и время создания медиафайла
     *
     * @return string
     */
    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    /**
     * Установить дату и время создания медиафайла
     *
     * @param string $createDate
     * @return self
     */
    public function setCreateDate(string $createDate): self
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * Получить размер медиафайла в байтах
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Установить размер медиафайла в байтах
     *
     * @param int $size
     * @return self
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * Получить MIME тип медиафайла
     *
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * Установить MIME тип медиафайла
     *
     * @param string $contentType
     * @return self
     */
    public function setContentType(string $contentType): self
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * Получить описание файла
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Установить описание файла
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
     * Сериализовать в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [
            'filename' => $this->filename,
            'sha256' => $this->sha256,
            'create_date' => $this->createDate,
            'size' => $this->size,
            'content_type' => $this->contentType,
        ];

        if ($this->description !== null) {
            $result['description'] = $this->description;
        }

        return $result;
    }
}