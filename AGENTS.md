# AGENTS.md - Developer Guidelines

This document provides essential information for agents working in this Symfony 7.4 PHP codebase.

## Project Overview

- **PHP Version**: 8.4+
- **Framework**: Symfony 7.4
- **Database**: PostgreSQL with Doctrine ORM
- **Test Framework**: PHPUnit 10
- **Code Quality**: PHP-CS-Fixer (Symfony rules), PHPStan level 5

## Build, Lint & Test Commands

```bash
# Dependencies
make install_deps          # Install PHP and npm dependencies
make update_deps          # Update all dependencies

# Assets
make assets                # Build assets (npm run build)
make watch                 # Watch mode for asset changes

# Code Quality
make check                 # Run all checks (lint, psr, twig, phpstan, doctrine)
make format                # Format code with PHP-CS-Fixer
make php_lint              # Run PHP-CS-Fixer (use ARGS="--dry-run" to check)
make phpstan               # Run PHPStan (level 5)
make twig_lint             # Validate Twig templates
make psr_lint              # Check PSR autoloading

# Testing
make test                  # Run all tests
make test_unit             # Run unit tests only
make test_integration      # Run integration tests only
make test_cov              # Run tests with code coverage (coverage.xml)

# Single test: php bin/phpunit --filter=testMethodName
# Or: php bin/phpunit path/to/TestFile.php --filter=testMethodName

# Database
make dbinstall             # Setup database and run migrations
make dbmigration           # Generate new migration
make dbfixtures            # Load test fixtures
```

## Code Style Guidelines

### General Rules
- **Strict Types**: All PHP files must start with `declare(strict_types=1);`
- **Final Classes**: Use `final` class modifier unless inheritance is required
- **PHP Version**: Code should be compatible with PHP 8.4+

### Naming Conventions
- **Classes**: `PascalCase` (e.g., `CreateModelCommandHandler`)
- **Methods/Properties**: `camelCase` (e.g., `getReference()`)
- **Constants**: `UPPER_CASE` with underscores
- **Interfaces**: Append `Interface` suffix (e.g., `ModelRepositoryInterface`)
- **Commands/Queries**: Use `Command`/`Query` suffix
- **Controllers**: Suffix with `Controller`
- **Form Types**: Suffix with `FormType`

### Import Organization
Imports ordered alphabetically within groups:
```php
use App\Application\CommandBusInterface;
use App\Application\Model\Command\CreateModelCommand;
use App\Domain\Model\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
```

### Code Formatting
- **Array syntax**: Short `[]` only (no `array()`)
- **Trailing commas**: Required in multiline arrays/arguments
- **Yoda style**: Disabled (use `==` not `==`)
- **Strict types**: Required

### Type Declarations
- Use explicit return types and constructor promotion
- Nullable: `?string`, Union: `string|int`
- Example: `public function __invoke(Command $command): ?Model`

### Error Handling
- Custom domain exceptions in `src/Domain/*/Exception/`
- Use `ReferenceAlreadyExistsException` style naming
- Handle exceptions in controllers with try/catch

### Named Arguments
```php
return new RedirectResponse(
    url: $this->router->generate('app_models_list', ['serie' => $serie->getUuid()]),
    status: Response::HTTP_SEE_OTHER,
);
```

## Architecture (Hexagonal/Ports & Adapters)

```
src/
├── Application/          # Use cases, commands, queries, interfaces
│   ├── Model/Command/     # Write operations
│   └── Model/Query/      # Read operations
├── Domain/                # Business logic, entities, repository interfaces
├── Infrastructure/        # Controllers, forms, persistence
│   ├── Controller/
│   ├── Form/
│   └── Persistence/Doctrine/
└── Kernel.php
```

### CQRS Pattern
- Commands via `CommandBusInterface`, handlers: `*CommandHandler`
- Queries via `QueryBusInterface`, handlers: `*QueryHandler`

### Repository Pattern
- Interfaces in `Domain/*/Repository/*RepositoryInterface.php`
- Implementations in `Infrastructure/Persistence/Doctrine/Repository/`

## Testing Conventions

### Integration Tests
- Extend `AbstractWebTestCase`
- Use `$this->login()` for authenticated requests
- Test naming: `test*` prefix

```php
public function testSuccessfullCreation(): void
{
    $client = $this->login();
    $crawler = $client->request('GET', '/some/path');
    $this->assertResponseStatusCodeSame(200);
}
```

### Test Assertions
- Use `$this->assertSame()`, `$this->assertInstanceOf()`
- Use `self::assertEquals()` inside test methods

## Git/Hooks
- **Pre-commit**: Runs `make husky_precommit`
- **Husky**: Configured in `.husky/`
- **Commit messages**: Follow conventional commits style
