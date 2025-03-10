<?php

namespace Rekorder\Markirovka\Controller;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Error;
use Exception;
use Rekorder\Markirovka\Repository\AccountRepository;
use Rekorder\Markirovka\Service\AccountService;

/**
 * Контроллер для работы с аккаунтами через REST API
 */
class AccountController extends Controller
{
    /** @var AccountService */
    private AccountService $accountService;

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
        $this->accountService = new AccountService();
    }

    /**
     * Настройка фильтров действий
     *
     * @return array
     */
    protected function getDefaultPreFilters(): array
    {
        return [
            new ActionFilter\Authentication(),
            new ActionFilter\HttpMethod([
                ActionFilter\HttpMethod::METHOD_GET,
                ActionFilter\HttpMethod::METHOD_POST
            ]),
            new ActionFilter\Csrf(),
        ];
    }

    /**
     * Получить список аккаунтов
     *
     * @param array $filter Фильтр
     * @param array $order Сортировка
     * @param int $limit Лимит
     * @param int $offset Смещение
     * @return array|null
     */
    public function getListAction(
        array $filter = [],
        array $order = ['ID' => 'ASC'],
        int $limit = 20,
        int $offset = 0
    ): ?array
    {
        try {
            $repository = new AccountRepository();
            return $repository->getList($filter, $order, ['*'], $limit, $offset);
        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage(), $e->getCode()));
            return null;
        }
    }

    /**
     * Получить аккаунт по ID
     *
     * @param int $id ID аккаунта
     * @return array|null
     */
    public function getByIdAction(int $id): ?array
    {
        try {
            return $this->accountService->getAccount($id);
        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage(), $e->getCode()));
            return null;
        }
    }

    /**
     * Создать аккаунт
     *
     * @param string $accessKey Ключ доступа
     * @param string|null $name Название аккаунта
     * @return array|null
     */
    public function createAction(string $accessKey, string $name = null): ?array
    {
        try {
            return $this->accountService->createAccount($name, $accessKey);
        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage(), $e->getCode()));
            return null;
        }
    }

    /**
     * Обновить аккаунт
     *
     * @param int $id ID аккаунта
     * @param array $data Данные для обновления
     * @return bool
     */
    public function updateAction(int $id, array $data): bool
    {
        try {
            return $this->accountService->updateAccount($id, $data);
        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage(), $e->getCode()));
            return false;
        }
    }

    /**
     * Удалить аккаунт
     *
     * @param int $id ID аккаунта
     * @return bool
     */
    public function deleteAction(int $id): bool
    {
        try {
            return $this->accountService->deleteAccount($id);
        } catch (Exception $e) {
            $this->addError(new Error($e->getMessage(), $e->getCode()));
            return false;
        }
    }
}