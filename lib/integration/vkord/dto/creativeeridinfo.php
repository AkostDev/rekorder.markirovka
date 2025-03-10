<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Информация о маркировке креатива
 */
class CreativeEridInfo implements JsonSerializable
{
    /** @var string Токен маркировки креатива */
    private string $marker;

    /** @var string Токен маркировки креатива */
    private string $erid;

    /**
     * @param string $marker Токен маркировки креатива
     * @param string $erid Токен маркировки креатива
     */
    public function __construct(string $marker, string $erid)
    {
        $this->marker = $marker;
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
            $data['marker'],
            $data['erid']
        );
    }

    /**
     * Получить токен маркировки креатива
     *
     * @return string
     */
    public function getMarker(): string
    {
        return $this->marker;
    }

    /**
     * Установить токен маркировки креатива
     *
     * @param string $marker
     * @return self
     */
    public function setMarker(string $marker): self
    {
        $this->marker = $marker;
        return $this;
    }

    /**
     * Получить токен ERID
     *
     * @return string
     */
    public function getErid(): string
    {
        return $this->erid;
    }

    /**
     * Установить токен ERID
     *
     * @param string $erid
     * @return self
     */
    public function setErid(string $erid): self
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
        return [
            'marker' => $this->marker,
            'erid' => $this->erid,
        ];
    }
}