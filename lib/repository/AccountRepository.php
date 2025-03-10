<?php

namespace Rekorder\Markirovka\Repository;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Exception;
use Rekorder\Markirovka\Entity\AccountTable;

/**
 * Репозиторий для работы с аккаунтами
 */
class AccountRepository
{
    /**
     * Получить аккаунт по ID
     *
     * @param int $id ID аккаунта
     * @return array|null
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getById(int $id): ?array
    {
        return AccountTable::getById($id)->fetch() ?: null;
    }

    /**
     * Получить аккаунт по ACCESS_KEY
     *
     * @param string $accessKey Ключ доступа
     * @return array|null
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getByAccessKey(string $accessKey): ?array
    {
        return AccountTable::getList([
            'filter' => ['=ACCESS_KEY' => $accessKey],
            'limit' => 1
        ])->fetch() ?: null;
    }

    /**
     * Получить список аккаунтов
     *
     * @param array $filter Фильтр
     * @param array $order Сортировка
     * @param array $select Выбираемые поля
     * @param int $limit Лимит
     * @param int $offset Смещение
     * @return array
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getList(
        array $filter = [],
        array $order = ['ID' => 'ASC'],
        array $select = ['*'],
        int $limit = 0,
        int $offset = 0
    ): array {
        $params = [
            'select' => $select,
            'filter' => $filter,
            'order' => $order,
        ];

        if ($limit > 0) {
            $params['limit'] = $limit;
            $params['offset'] = $offset;
        }

        return AccountTable::getList($params)->fetchAll();
    }

    /**
     * Добавить аккаунт
     *
     * @param array $data Данные аккаунта
     * @return int ID добавленного аккаунта
     * @throws Exception
     */
    public function add(array $data): int
    {
        $result = AccountTable::add($data);
        if (!$result->isSuccess()) {
            throw new Exception(implode(', ', $result->getErrorMessages()));
        }
        return $result->getId();
    }

    /**
     * Обновить аккаунт
     *
     * @param int $id ID аккаунта
     * @param array $data Данные для обновления
     * @return bool
     * @throws Exception
     */
    public function update(int $id, array $data): bool
    {
        $result = AccountTable::update($id, $data);
        return $result->isSuccess();
    }

    /**
     * Удалить аккаунт
     *
     * @param int $id ID аккаунта
     * @return bool
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $result = AccountTable::delete($id);
        return $result->isSuccess();
    }
}