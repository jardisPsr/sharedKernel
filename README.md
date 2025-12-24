# JardisPsr SharedKernel

![Build Status](https://github.com/jardispsr/sharedkernel/actions/workflows/ci.yml/badge.svg)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.2-blue.svg)](https://www.php.net/)
[![PHPStan Level](https://img.shields.io/badge/PHPStan-Level%208-success.svg)](phpstan.neon)
[![PSR-4](https://img.shields.io/badge/autoload-PSR--4-blue.svg)](https://www.php-fig.org/psr/psr-4/)
[![PSR-12](https://img.shields.io/badge/code%20style-PSR--12-orange.svg)](phpcs.xml)

**Interface library** providing domain shared kernel contracts for Domain-Driven Design (DDD) applications. This package contains primarily interfaces with minimal implementation - only strictly typed PHP 8.2+ contracts defining the boundaries for bounded contexts, workflows, and domain-level abstractions.

**Note:** This package includes one concrete implementation (`DomainRequest`) as a shared kernel base class for cross-context request handling.

## Installation

```bash
composer require jardispsr/sharedkernel
```

## Requirements

- PHP >= 8.2
- jardispsr/dbconnection ^1.0
- jardispsr/dbquery ^1.0
- jardispsr/factory ^1.0
- jardispsr/messaging ^1.0
- jardispsr/validation ^1.0
- psr/simple-cache ^3.0
- psr/log ^3.0

## Architecture Overview

This library provides the foundational contracts for implementing Domain-Driven Design patterns with a focus on type safety and clear separation of concerns.

### Core Interfaces

#### DomainKernelInterface
Central service container providing access to infrastructure components:
- **Path Resolution**: Application and domain root paths (`getAppRoot()`, `getDomainRoot()`)
- **Environment**: Configuration and environment variable access (`getEnv(?string $key)`)
- **Services**: Factory (`getFactory()`), Cache PSR-16 (`getCache()`), Logger PSR-3 (`getLogger()`)
- **Infrastructure**: Database service (`getDatabase()`), Data service (`getDataService()`), Messaging (`getMessage()`)

#### BoundedContextInterface
Generic type-safe use case executor:
```php
public function handle(string $className, mixed ...$parameters): mixed;
```
Instantiates and executes handlers within a bounded context, supporting dependency injection and flexible parameter passing.

#### WorkflowInterface + WorkFlowConfigInterface
Multi-step workflow orchestration:
- Executes through `BoundedContextInterface`
- Supports conditional branching (`onSuccess`/`onFail` handlers)
- Node-based configuration for complex business processes

#### DomainRequest
Immutable base class for domain requests (shared kernel implementation):
```php
readonly class DomainRequest {
    public function __construct(
        public mixed $tenantId,
        public mixed $userId,
        public mixed $version,
        public array $payload
    ) {}
}
```
- **Immutable**: Readonly class ensures request integrity
- **Context-aware**: Carries tenant, user, and version information
- **Flexible payload**: Key-value array for use-case parameters
- **Extensible**: Bounded contexts can extend with typed getters

**Design Note:** This is the only concrete implementation in this package, included as a shared kernel element to standardize request handling across bounded contexts.

#### DomainResponseInterface
Standardized response contract for bounded contexts:

**DomainResponseInterface** features:
- Message and error collection (recursive and non-recursive)
- Domain event tracking (`array<int, object>`)
- Nested sub-context response aggregation
- Success/failure state management
- Metadata summaries with full PHPStan Level 8 type coverage

### SharedKernel Interfaces

#### DatabaseServiceInterface
Query builder pattern with connection pooling:
- Fluent query builders (SELECT, INSERT, UPDATE, DELETE)
- Connection pool management via `jardispsr/dbconnection`
- Persist operations for entity storage

#### DataServiceInterface
Reflection-based entity management:
- **Hydration**: From database rows and nested arrays
- **Change Tracking**: Snapshot-based detection via `getChanges()`, `hasChanges()`, `getChangedFields()`
- **Operations**: Clone entities, diff comparison, array conversion
- **Batch**: Load multiple entities efficiently

### Typical Application Flow

```
DomainRequest → BoundedContext.handle(UseCase)
                        ↓
                  (optional) Workflow with WorkFlowConfig nodes
                        ↓
                DomainResponse with sub-contexts and events
                        ↓
                Infrastructure services accessed via DomainKernelInterface
```

## Development

All development commands run inside Docker containers for consistent environments.

### Available Commands

```bash
make install     # Install Composer dependencies
make update      # Update Composer dependencies
make autoload    # Regenerate autoload files
make phpstan     # Run PHPStan static analysis (Level 8)
make phpcs       # Run PHP_CodeSniffer (PSR-12)
make shell       # Access Docker container shell
make help        # Show all available commands
```

### Code Quality Standards

- **PHPStan Level 8** - Maximum strictness with full type coverage
- **PSR-12** coding standard with 120-character line limit
- **Strict types** required in all PHP files (`declare(strict_types=1)`)
- **Pre-commit hooks** validate branch naming and run phpcs on staged files

### Branch Naming Convention

Branches must follow this pattern:
```
(feature|fix|hotfix)/[1-7 digits]_[alphanumeric-_]+
```

Example: `feature/123_add-workflow-interface`

## License

MIT License - see [LICENSE](LICENSE) file for details.

## Support

- **Issues:** [GitHub Issues](https://github.com/JardisPsr/sharedkernel/issues)
- **Email:** jardisCore@headgent.dev

## Authors

Jardis Core Development
