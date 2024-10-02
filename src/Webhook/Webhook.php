<?php

declare(strict_types=1);

namespace Datlechin\SePay\Webhook;

use Closure;
use InvalidArgumentException;

class Webhook
{
    public const AUTH_NONE = 'none';

    public const AUTH_API_KEY = 'api_key';

    protected string $authorizationType;

    protected ?string $authorizationToken;

    public function __construct(
        string $authorizationType = self::AUTH_NONE,
        ?string $authorizationToken = null
    ) {
        $this->authorizationType = $authorizationType;
        $this->authorizationToken = $authorizationToken;
    }

    /**
     * Handle the webhook request.
     *
     * @param \Closure $callback
     */
    public function handle(Closure $callback): void
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        if (
            json_last_error() !== JSON_ERROR_NONE
            || empty($payload)
            || ! $this->validatePayload($payload)
        ) {
            $this->respond(false);
        }

        if (! $this->authorize()) {
            $this->respond(false);
        }

        $response = $callback(new Payload($payload));

        $this->respond($response);
    }

    /**
     * Set the authorization type and token.
     */
    public function setAuthorization(string $type, ?string $token = null): self
    {
        if (! in_array($type, [self::AUTH_NONE, self::AUTH_API_KEY])) {
            throw new InvalidArgumentException('Invalid authorization type');
        }

        $this->authorizationType = $type;
        $this->authorizationToken = $token;

        return $this;
    }

    /**
     * Respond to the webhook request.
     */
    protected function respond(bool $success): void
    {
        http_response_code($success ? 201 : 400);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }

    /**
     * Authorize the request.
     */
    public function authorize(): bool
    {
        if ($this->authorizationType === self::AUTH_NONE) {
            return true;
        }

        if ($this->authorizationType === self::AUTH_API_KEY) {
            return $this->authorizeWithApiKey();
        }

        return false;
    }

    /**
     * Authorize the request using an API key.
     */
    protected function authorizeWithApiKey(): bool
    {
        $headers = $this->getHeaders();

        if (! isset($headers['Authorization'])) {
            return false;
        }

        return $headers['Authorization'] === "Apikey {$this->authorizationToken}";
    }

    /**
     * Validate the payload.
     */
    public function validatePayload(array $payload): bool
    {
        $requiredFields = [
            'id' => 'integer',
            'gateway' => 'string',
            'transactionDate' => 'string',
            'accountNumber' => 'string',
            'transferType' => 'string',
            'transferAmount' => 'integer',
            'accumulated' => 'integer',
            'referenceCode' => 'string',
        ];

        foreach ($requiredFields as $field => $type) {
            if (! isset($payload[$field]) || gettype($payload[$field]) !== $type) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get all headers from the request.
     */
    public function getHeaders(): array
    {
        if (! function_exists('getallheaders')) {
            return [];
        }

        return getallheaders();
    }
}
