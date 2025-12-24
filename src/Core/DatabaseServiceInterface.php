<?php

declare(strict_types=1);

namespace JardisPsr\SharedKernel\Core;

use JardisPsr\DbConnection\ConnectionPoolInterface;
use JardisPsr\DbQuery\DbDeleteBuilderInterface;
use JardisPsr\DbQuery\DbInsertBuilderInterface;
use JardisPsr\DbQuery\DbPersistInterface;
use JardisPsr\DbQuery\DbQueryBuilderInterface;
use JardisPsr\DbQuery\DbUpdateBuilderInterface;

/**
 * Represents an interface for database operations and access to various
 * related components, including connection pool management and query builders.
 */
interface DatabaseServiceInterface
{
    /**
     * Returns the connection pool for managing database connections.
     *
     * @return ConnectionPoolInterface|null The connection pool instance or null if not available.
     */
    public function geConnection(): ?ConnectionPoolInterface;

    /**
     * Returns the persist handler for database operations.
     *
     * @return DbPersistInterface The persist handler instance.
     */
    public function getPersist(): DbPersistInterface;

    /**
     * Returns a query builder for SELECT operations.
     *
     * @return DbQueryBuilderInterface The SELECT query builder instance.
     */
    public function getSelectBuilder(): DbQueryBuilderInterface;

    /**
     * Returns a query builder for INSERT operations.
     *
     * @return DbInsertBuilderInterface The INSERT query builder instance.
     */
    public function getInsertBuilder(): DbInsertBuilderInterface;

    /**
     * Returns a query builder for UPDATE operations.
     *
     * @return DbUpdateBuilderInterface The UPDATE query builder instance or null if not available.
     */
    public function getUpdateBuilder(): DbUpdateBuilderInterface;

    /**
     * Returns a query builder for DELETE operations.
     *
     * @return DbDeleteBuilderInterface The DELETE query builder instance.
     */
    public function getDeleteBuilder(): DbDeleteBuilderInterface;
}
