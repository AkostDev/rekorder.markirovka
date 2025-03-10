<?php

namespace Rekorder\Markirovka\Integration\VkOrd\DTO;

use JsonSerializable;

/**
 * Список статистики
 */
class StatisticItems implements JsonSerializable
{
    /** @var array|null Элементы статистики */
    private ?array $items;

    /** @var int|null Количество элементов, которые необходимо получить за один запрос */
    private ?int $limit;

    /** @var int|null Общее количество элементов для выдачи по запросу */
    private ?int $totalItemsCount;

    /**
     * @param array|null $items Элементы статистики
     * @param int|null $limit Количество элементов, которые необходимо получить за один запрос
     * @param int|null $totalItemsCount Общее количество элементов для выдачи по запросу
     */
    public function __construct(?array $items = null, ?int $limit = null, ?int $totalItemsCount = null)
    {
        $this->items = $items;
        $this->limit = $limit;
        $this->totalItemsCount = $totalItemsCount;
    }

    /**
     * Создать объект из массива данных
     *
     * @param array $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        $items = null;

        if (isset($data['items']) && is_array($data['items'])) {
            $items = [];
            foreach ($data['items'] as $itemData) {
                $items[] = Statistic::fromArray($itemData);
            }
        }

        return new self(
            $items,
            $data['limit'] ?? null,
            $data['total_items_count'] ?? null
        );
    }

    /**
     * Получить элементы статистики
     *
     * @return array|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Установить элементы статистики
     *
     * @param array|null $items
     * @return self
     */
    public function setItems(?array $items): self
    {
        $this->items = $items;
        return $this;
    }

    /**
     * Добавить элемент статистики
     *
     * @param Statistic $item
     * @return self
     */
    public function addItem(Statistic $item): self
    {
        if ($this->items === null) {
            $this->items = [];
        }

        $this->items[] = $item;
        return $this;
    }

    /**
     * Получить лимит элементов
     *
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * Установить лимит элементов
     *
     * @param int|null $limit
     * @return self
     */
    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * Получить общее количество элементов
     *
     * @return int|null
     */
    public function getTotalItemsCount(): ?int
    {
        return $this->totalItemsCount;
    }

    /**
     * Установить общее количество элементов
     *
     * @param int|null $totalItemsCount
     * @return self
     */
    public function setTotalItemsCount(?int $totalItemsCount): self
    {
        $this->totalItemsCount = $totalItemsCount;
        return $this;
    }

    /**
     * Сериализовать в JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        $result = [];

        if ($this->items !== null) {
            $result['items'] = $this->items;
        }

        if ($this->limit !== null) {
            $result['limit'] = $this->limit;
        }

        if ($this->totalItemsCount !== null) {
            $result['total_items_count'] = $this->totalItemsCount;
        }

        return $result;
    }
}