<?php

namespace Rekorder\Markirovka\Integration\VkOrd;

use Exception;
use Rekorder\Markirovka\Integration\VkOrd\Api\Client;
use Rekorder\Markirovka\Integration\VkOrd\DTO\Person;
use Rekorder\Markirovka\Integration\VkOrd\DTO\Contract;
use Rekorder\Markirovka\Integration\VkOrd\DTO\Creative;
use Rekorder\Markirovka\Integration\VkOrd\DTO\CreativeEridInfo;
use Rekorder\Markirovka\Integration\VkOrd\DTO\Pad;

/**
 * Сервис для работы с API ВК ОРД
 */
class Service
{
    /** @var Client */
    private Client $client;

    /**
     * @param Client|null $client Клиент API ВК ОРД
     */
    public function __construct(?Client $client = null)
    {
        $this->client = $client ?: new Client();
    }

    /**
     * Получить список идентификаторов контрагентов
     *
     * @param int|null $offset Смещение
     * @param int|null $limit Количество записей
     * @return array
     * @throws Exception
     */
    public function getPersonList(int $offset = null, int $limit = null): array
    {
        $params = [];

        if ($offset !== null) {
            $params['offset'] = $offset;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        return $this->client->get('v1/person', $params);
    }

    /**
     * Создать или обновить контрагента
     *
     * @param string $externalId Внешний идентификатор контрагента
     * @param Person $person Данные контрагента
     * @return bool
     * @throws Exception
     */
    public function setPerson(string $externalId, Person $person): bool
    {
        return $this->client->put('v1/person/' . $externalId, $person->jsonSerialize());
    }

    /**
     * Получить данные контрагента
     *
     * @param string $externalId Внешний идентификатор контрагента
     * @return Person
     * @throws Exception
     */
    public function getPerson(string $externalId): Person
    {
        $data = $this->client->get('v1/person/' . $externalId);
        return Person::fromArray($data);
    }

    /**
     * Получить список идентификаторов договоров
     *
     * @param int|null $offset Смещение
     * @param int|null $limit Количество записей
     * @return array
     * @throws Exception
     */
    public function getContractList(int $offset = null, int $limit = null): array
    {
        $params = [];

        if ($offset !== null) {
            $params['offset'] = $offset;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        return $this->client->get('v1/contract', $params);
    }

    /**
     * Создать или обновить договор
     *
     * @param string $externalId Внешний идентификатор договора
     * @param Contract $contract Данные договора
     * @return bool
     * @throws Exception
     */
    public function setContract(string $externalId, Contract $contract): bool
    {
        return $this->client->put('v1/contract/' . $externalId, $contract->jsonSerialize());
    }

    /**
     * Получить данные договора
     *
     * @param string $externalId Внешний идентификатор договора
     * @return Contract
     * @throws Exception
     */
    public function getContract(string $externalId): Contract
    {
        $data = $this->client->get('v1/contract/' . $externalId);
        return Contract::fromArray($data);
    }

    /**
     * Получить список идентификаторов креативов
     *
     * @param int|null $offset Смещение
     * @param int|null $limit Количество записей
     * @return array
     * @throws Exception
     */
    public function getCreativeList(int $offset = null, int $limit = null): array
    {
        $params = [];

        if ($offset !== null) {
            $params['offset'] = $offset;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        return $this->client->get('v1/creative', $params);
    }

    /**
     * Создать или обновить креатив
     *
     * @param string $externalId Внешний идентификатор креатива
     * @param Creative $creative Данные креатива
     * @return CreativeEridInfo
     * @throws Exception
     */
    public function setCreative(string $externalId, Creative $creative): CreativeEridInfo
    {
        $data = $this->client->put('v2/creative/' . $externalId, $creative->jsonSerialize());
        return CreativeEridInfo::fromArray($data);
    }

    /**
     * Получить данные креатива
     *
     * @param string $externalId Внешний идентификатор креатива
     * @return Creative
     * @throws Exception
     */
    public function getCreative(string $externalId): Creative
    {
        $data = $this->client->get('v2/creative/' . $externalId);
        return Creative::fromArray($data);
    }

    /**
     * Получить данные креатива по маркеру рекламы
     *
     * @param string $erid Маркер рекламы
     * @return Creative
     * @throws Exception
     */
    public function getCreativeByErid(string $erid): Creative
    {
        $data = $this->client->get('v2/creative/by_erid/' . $erid);
        return Creative::fromArray($data);
    }

    /**
     * Получить список идентификаторов рекламных площадок
     *
     * @param int|null $offset Смещение
     * @param int|null $limit Количество записей
     * @return array
     * @throws Exception
     */
    public function getPadList(int $offset = null, int $limit = null): array
    {
        $params = [];

        if ($offset !== null) {
            $params['offset'] = $offset;
        }

        if ($limit !== null) {
            $params['limit'] = $limit;
        }

        return $this->client->get('v1/pad', $params);
    }

    /**
     * Создать или обновить рекламную площадку
     *
     * @param string $externalId Внешний идентификатор рекламной площадки
     * @param Pad $pad Данные рекламной площадки
     * @return bool
     * @throws Exception
     */
    public function setPad(string $externalId, Pad $pad): bool
    {
        return $this->client->put('v1/pad/' . $externalId, $pad->jsonSerialize());
    }

    /**
     * Получить данные рекламной площадки
     *
     * @param string $externalId Внешний идентификатор рекламной площадки
     * @return Pad
     * @throws Exception
     */
    public function getPad(string $externalId): Pad
    {
        $data = $this->client->get('v1/pad/' . $externalId);
        return Pad::fromArray($data);
    }

    /**
     * Загрузить медиафайл
     *
     * @param string $externalId Внешний идентификатор медиафайла
     * @param string $filePath Путь к файлу
     * @param string $description Описание файла
     * @return array
     * @throws Exception
     */
    public function uploadMedia(string $externalId, string $filePath, string $description): array
    {
        return $this->client->uploadFile('v1/media/' . $externalId, $filePath, [
            'description' => $description
        ]);
    }

    /**
     * Добавить тексты в креатив
     *
     * @param string $externalId Внешний идентификатор креатива
     * @param array $texts Список текстов
     * @return CreativeEridInfo
     * @throws Exception
     */
    public function addTextToCreative(string $externalId, array $texts): CreativeEridInfo
    {
        $data = $this->client->post('v1/creative/' . $externalId . '/add_text', ['texts' => $texts]);
        return CreativeEridInfo::fromArray($data);
    }

    /**
     * Добавить медиафайлы в креатив
     *
     * @param string $externalId Внешний идентификатор креатива
     * @param array $mediaExternalIds Список внешних идентификаторов медиафайлов
     * @return CreativeEridInfo
     * @throws Exception
     */
    public function addMediaToCreative(string $externalId, array $mediaExternalIds): CreativeEridInfo
    {
        $data = $this->client->post('v1/creative/' . $externalId . '/add_media', [
            'media_external_ids' => $mediaExternalIds
        ]);
        return CreativeEridInfo::fromArray($data);
    }

    /**
     * Получить клиент API
     *
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }
}