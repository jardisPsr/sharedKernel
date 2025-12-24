<?php

declare(strict_types=1);

namespace JardisPsr\SharedKernel;

/**
 * Base class for all domain requests.
 *
 * Immutable request object that carries:
 * - RequestContext (tenant, user, version) - type-safe
 * - Payload (use-case parameters) - flexible key-value
 *
 * Flow:
 * WebRequest → Controller → DomainRequest → BC ContextMap → BC Method
 *
 * Bounded contexts can extend this class to add typed getters
 * for their specific use-case parameters.
 *
 * The request is readonly and must not be modified during the call stack.
 * Use DomainResponse to collect results.
 */
readonly class DomainRequest
{
    /**
     * @param array<string, mixed> $payload
     */
    public function __construct(
        public mixed $tenantId,
        public mixed $userId,
        public mixed $version,
        public array $payload
    ) {
    }

    /**
     * Get value from the payload with optional type casting.
     *
     * @param string $key The key in payload
     * @return mixed The value (optionally type-casted), or null if the key missing or cast fails
     */
    protected function get(string $key): mixed
    {
        return $this->payload[$key] ?? null;
    }

    /**
     * Check if the payload contains a key.
     */
    protected function has(string $key): bool
    {
        return array_key_exists($key, $this->payload);
    }
}
