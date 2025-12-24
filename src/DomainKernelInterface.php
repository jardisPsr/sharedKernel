<?php

declare(strict_types=1);

namespace JardisPsr\SharedKernel;

use JardisPsr\Factory\FactoryInterface;
use JardisPsr\Messaging\MessagingServiceInterface;
use JardisPsr\SharedKernel\Core\DatabaseServiceInterface;
use JardisPsr\SharedKernel\Core\DataServiceInterface;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Core domain interface providing access to infrastructure components.
 *
 * Acts as a service container for domain-driven design, providing access to
 * essential infrastructure services like a database, cache, messaging, and logging.
 */
interface DomainKernelInterface
{
    /**
     * Gets the application root directory path.
     *
     * @return string Absolute path to the application root
     */
    public function getAppRoot(): string;

    /**
     * Gets the domain root directory path.
     *
     * @return string Absolute path to the domain root
     */
    public function getDomainRoot(): string;

    /**
     * Gets environment configuration value(s).
     *
     * @param string|null $key Optional key to retrieve specific config value
     * @return mixed|array<string, mixed> Single value if key provided, all config if null
     */
    public function getEnv(?string $key = null): mixed;

    /**
     * Gets the factory for creating domain objects.
     *
     * @return FactoryInterface|null Factory instance or null if not configured
     */
    public function getFactory(): ?FactoryInterface;

    /**
     * Gets the PSR-16 simple cache implementation.
     *
     * @return CacheInterface|null Cache instance or null if not configured
     */
    public function getCache(): ?CacheInterface;

    /**
     * Retrieves the database service instance.
     *
     * @return DatabaseServiceInterface|null The database service instance or null if unavailable.
     */
    public function getDatabase(): ?DatabaseServiceInterface;

    /**
     * Retrieves the data service instance.
     *
     * @return DataServiceInterface|null The data service instance or null if unavailable
     */
    public function getDataService(): ?DataServiceInterface;

    /**
     * Gets the PSR-3 logger implementation.
     *
     * @return LoggerInterface|null Logger instance or null if not configured
     */
    public function getLogger(): ?LoggerInterface;

    /**
     * Gets the message publisher for event-driven architecture.
     *
     * @return MessagingServiceInterface|null Message publisher or null if not configured
     */
    public function getMessage(): ?MessagingServiceInterface;
}
