<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Информация о списке внешних идентификаторов
 */
class ExternalIdItems implements JsonSerializable
{
    /** @var array Список внешних идентификаторов */
    private array $externalIds;

    /** @var int Общее количество элементов для выдачи по запросу */
    private int $totalItemsCount;

    /** @var int Количество всех элементов, которые необходимо получить за один запрос */
    private int $limit;

    /**
     * @param array $externalIds Список внешних идентификаторов
     * @param int $totalItemsCount Общее количество элементов
     * @param int $limit Количество элементов на страницу
     */
    public function __construct(array $externalIds, int $totalItemsCount, int $limit)
    {
        $this->externalIds = $externalIds;
        $this->totalItemsCount = $totalItemsCount;
        $this->limit = $limit;
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
            $data['external_ids'],
            $data['total_items_count'],
            $data['limit']
        );
    }

    /**
     * Получить список внешних идентификаторов
     *
     * @return array
     */
    public function getExternalIds(): array
    {
        return $this->externalIds;
    }

    /**
     * Установить список внешних идентификаторов
     *
     * @param array $externalIds
     * @return self
     */
    public function setExternalIds(array $externalIds): self
    {
        $this->externalIds = $externalIds;
        return $this;
    }

    /**
     * Получить общее количество элементов
     *
     * @return int
     */
    public function getTotalItemsCount(): int
    {
        return $this->totalItemsCount;
    }

    /**
     * Установить общее количество элементов
     *
     * @param int $totalItemsCount
     * @return self
     */
    public function setTotalItemsCount(int $totalItemsCount): self
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    /**
     * Получить лимит элементов на страницу
     *
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * Установить лимит элементов на страницу
     *
     * @param int $limit
     * @return self
     */
    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
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
            'external_ids' => $this->externalIds,
            'total_items_count' => $this->totalItemsCount,
            'limit' => $this->limit,
        ];
    }
}