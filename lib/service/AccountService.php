<?php
namespace Rekorder\Markirovka\Service;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use Bitrix\Main\Type\DateTime;
use Exception;
use Rekorder\Markirovka\Entity\AccountTable;

class AccountService
{
    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getList(array $parameters = []): array
    {
        return AccountTable::getList($parameters)->fetchAll();
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getById($id): false|array
    {
        return AccountTable::getById($id)->fetch();
    }

    /**
     * @throws Exception
     */
    public function create(array $data): Result
    {
        $result = new Result();

        if (empty($data['ACCESS_KEY'])) {
            $result->addError(new Error('Ключ доступа не может быть пустым'));
            return $result;
        }

        $addResult = AccountTable::add($data);

        if (!$addResult->isSuccess()) {
            $result->addErrors($addResult->getErrors());
        } else {
            $result->setData(['ID' => $addResult->getId()]);
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function update($id, array $data): Result
    {
        $result = new Result();

        if (empty($id)) {
            $result->addError(new Error('ID аккаунта не может быть пустым'));
            return $result;
        }

        $data['DATE_UPDATE'] = new DateTime();

        $updateResult = AccountTable::update($id, $data);

        if (!$updateResult->isSuccess()) {
            $result->addErrors($updateResult->getErrors());
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    public function delete($id): Result
    {
        $result = new Result();

        if (empty($id)) {
            $result->addError(new Error('ID аккаунта не может быть пустым'));
            return $result;
        }

        $deleteResult = AccountTable::delete($id);

        if (!$deleteResult->isSuccess()) {
            $result->addErrors($deleteResult->getErrors());
        }

        return $result;
    }
}