# webservco/error

A PHP component/library.

Custom application error handling.

---

## Usage

Implement interfaces:

### `ErrorHandlerInterface`

```php
interface ErrorHandlerInterface
{
    public function handle(
        // The first parameter, errno, will be passed the level of the error raised, as an integer.
        int $errno,
        // The second parameter, errstr, will be passed the error message, as a string.
        string $errstr,
        // If the callback accepts a third parameter, errfile,
        // it will be passed the filename that the error was raised in, as a string.
        string $errfile,
        // If the callback accepts a fourth parameter, errline,
        // it will be passed the line number where the error was raised, as an integer.
        int $errline,
        // $errcontext removed in PHP 8
    ): bool;
}
```

### `ErrorHandlingServiceFactoryInterface`

```php
interface ErrorHandlingServiceFactoryInterface
{
    public function createErrorHandlingService(): ErrorHandlingServiceInterface;
}
```

### `ErrorHandlingServiceInterface`

```php
interface ErrorHandlingServiceInterface
{
    public function handlePreExecutionErrors(): bool;

    public function initialize(): bool;

    public function restore(): bool;
}
```

---

## Example implementation

A simple handling service using a strict error handler (throws exception for any error) is provided.


```php
// Create service.
$errorHandlingServiceFactory = new DefaultErrorHandlingServiceFactory();
$errorHandlingService = $errorHandlingServiceFactory->createErrorHandlingService();

// In application bootstrap:
$errorHandlingService->initialize();
$errorHandlingService->handlePreExecutionErrors();

// Application run.

// In application shutdown:
$errorHandlingService->restore();
```
