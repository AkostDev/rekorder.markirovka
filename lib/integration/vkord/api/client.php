<?php

namespace Rekorder\Markirovka\Integration\VkOrd\Api;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Web\Json;
use Bitrix\Main\Config\Option;
use CFile;
use Rekorder\Markirovka\Integration\VkOrd\Api\Exceptions\NotFoundException;
use Rekorder\Markirovka\Integration\VkOrd\Api\Exceptions\BadRequestException;
use Rekorder\Markirovka\Integration\VkOrd\Api\Exceptions\UnauthorizedException;
use Rekorder\Markirovka\Integration\VkOrd\Api\Exceptions\ConflictException;
use Rekorder\Markirovka\Integration\VkOrd\Api\Exceptions\InternalServerErrorException;

/**
 * Клиент API для работы с ВК ОРД
 */
class Client
{
    /** @var string */
    private string $baseUrl;

    /** @var string */
    private string $token;

    /** @var int Таймаут запросов в секундах */
    private int $timeout = 30;

    /** @var array HTTP заголовки */
    private array $headers;

    /**
     * Конструктор клиента API
     *
     * @param string|null $baseUrl URL API (если null, берется из настроек модуля)
     * @param string|null $token Токен авторизации (если null, берется из настроек модуля)
     */
    public function __construct(?string $baseUrl = null, ?string $token = null)
    {
        $moduleId = 'rekorder.markirovka';

        $this->baseUrl = $baseUrl ?: Option::get($moduleId, 'vkord_api_url', 'https://api.ord.vk.com');
        $this->token = $token ?: Option::get($moduleId, 'vkord_api_token', '');

        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Установить URL API
     *
     * @param string $baseUrl
     * @return $this
     */
    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;
        return $this;
    }

    /**
     * Установить токен авторизации
     *
     * @param string $token
     * @return $this
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        $this->headers['Authorization'] = 'Bearer ' . $token;
        return $this;
    }

    /**
     * Установить таймаут запросов
     *
     * @param int $timeout Таймаут в секундах
     * @return $this
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Выполнить GET-запрос
     *
     * @param string $endpoint Конечная точка API
     * @param array $params Параметры запроса
     * @return mixed
     * @throws \Exception
     */
    public function get(string $endpoint, array $params = []): mixed
    {
        return $this->request('GET', $endpoint, $params);
    }

    /**
     * Выполнить POST-запрос
     *
     * @param string $endpoint Конечная точка API
     * @param array $data Данные для отправки
     * @param array $params Параметры запроса (для query string)
     * @return mixed
     * @throws \Exception
     */
    public function post(string $endpoint, array $data = [], array $params = []): mixed
    {
        return $this->request('POST', $endpoint, $params, $data);
    }

    /**
     * Выполнить PUT-запрос
     *
     * @param string $endpoint Конечная точка API
     * @param array $data Данные для отправки
     * @param array $params Параметры запроса (для query string)
     * @return mixed
     * @throws \Exception
     */
    public function put(string $endpoint, array $data = [], array $params = []): mixed
    {
        return $this->request('PUT', $endpoint, $params, $data);
    }

    /**
     * Выполнить DELETE-запрос
     *
     * @param string $endpoint Конечная точка API
     * @param array $params Параметры запроса
     * @return mixed
     * @throws \Exception
     */
    public function delete(string $endpoint, array $params = []): mixed
    {
        return $this->request('DELETE', $endpoint, $params);
    }

    /**
     * Выполнить PATCH-запрос
     *
     * @param string $endpoint Конечная точка API
     * @param array $data Данные для отправки
     * @param array $params Параметры запроса (для query string)
     * @return mixed
     * @throws \Exception
     */
    public function patch(string $endpoint, array $data = [], array $params = []): mixed
    {
        return $this->request('PATCH', $endpoint, $params, $data);
    }

    /**
     * Загрузить файл
     *
     * @param string $endpoint Конечная точка API
     * @param string $filePath Путь к файлу
     * @param array $params Дополнительные параметры
     * @return mixed
     * @throws \Exception
     */
    public function uploadFile(string $endpoint, string $filePath, array $params = []): mixed
    {
        if (!file_exists($filePath)) {
            throw new \Exception("Файл не найден: $filePath");
        }

        $httpClient = new HttpClient([
            'timeout' => $this->timeout,
            'headers' => array_merge($this->headers, [
                'Content-Type' => 'multipart/form-data',
            ]),
        ]);

        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/') . $queryString;

        $httpClient->setHeader('Authorization', 'Bearer ' . $this->token);

        $result = $httpClient->post($url, [
            'media_file' => CFile::makeFileArray($filePath),
        ]);

        $status = $httpClient->getStatus();

        if ($status !== 200 && $status !== 201) {
            $this->handleError($status, $result);
        }

        return $this->parseResponse($result);
    }

    /**
     * Выполнить запрос к API
     *
     * @param string $method HTTP метод
     * @param string $endpoint Конечная точка API
     * @param array $params Параметры запроса (для query string)
     * @param array|null $data Данные для отправки
     * @return mixed
     * @throws Exception
     * @throws ArgumentException
     * @throws \Exception
     */
    private function request(string $method, string $endpoint, array $params = [], array $data = null): mixed
    {
        $httpClient = new HttpClient([
            'timeout' => $this->timeout,
            'headers' => $this->headers,
        ]);

        $queryString = !empty($params) ? '?' . http_build_query($params) : '';
        $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/') . $queryString;

        $requestBody = null;
        if ($data !== null) {
            $requestBody = Json::encode($data);
        }

        $result = match ($method) {
            'GET' => $httpClient->get($url),
            'POST' => $httpClient->post($url, $requestBody),
            'PUT', 'DELETE', 'PATCH' => $httpClient->query($method, $url, $requestBody),
            default => throw new \Exception("Неподдерживаемый HTTP-метод: $method"),
        };

        $status = $httpClient->getStatus();

        if ($status !== 200 && $status !== 201) {
            $this->handleError($status, $result);
        }

        if (empty($result)) {
            return true;
        }

        return $this->parseResponse($result);
    }

    /**
     * Разобрать ответ API
     *
     * @param string $response JSON-ответ
     * @return mixed
     */
    private function parseResponse(string $response): mixed
    {
        try {
            return Json::decode($response);
        } catch (\Exception $e) {
            // Возможно, ответ не является JSON (например, бинарные данные)
            return $response;
        }
    }

    /**
     * Обработать ошибку API
     *
     * @param int $status HTTP-статус
     * @param string $response Тело ответа
     * @throws Exception
     */
    private function handleError(int $status, string $response): void
    {

        try {
            $errorData = Json::decode($response);
        } catch (\Exception $e) {
            $errorData = ['error' => 'Неизвестная ошибка: ' . $response];
        }

        $errorMessage = $errorData['error'] ?? 'Неизвестная ошибка';

        throw match ($status) {
            400 => new BadRequestException($errorMessage, $status),
            401 => new UnauthorizedException($errorMessage, $status),
            404 => new NotFoundException($errorMessage, $status),
            409 => new ConflictException($errorMessage, $status),
            500 => new InternalServerErrorException($errorMessage, $status),
            default => new Exception($errorMessage, $status),
        };
    }
}