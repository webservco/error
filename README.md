# webservco/error

A PHP component/library. Please see [webservco/sandbox](https://webservco.github.io/sandbox/) for an example project using these types of components.

PHP error handling for an application, with a default handler that turns every PHP error into an ErrorException.

- Related: `webservco/application-default` (runs this service during bootstrap and shutdown), `webservco/exception` (handles the exceptions this throws)

---

## Installation

```shell
composer require webservco/error
```

---

## Usage

```php
use WebServCo\Error\Factory\DefaultErrorHandlingServiceFactory;

$errorHandlingServiceFactory = new DefaultErrorHandlingServiceFactory();
// \WebServCo\Error\Contract\ErrorHandlingServiceInterface
$errorHandlingService = $errorHandlingServiceFactory->createErrorHandlingService();

// Application bootstrap, after the exception handler is set.
$errorHandlingService->initialize();
$errorHandlingService->handlePreExecutionErrors();

// Application run.

// Application shutdown.
$errorHandlingService->restore();
```

With `webservco/application-default` you don't call these yourself. Pass the factory to the application factory and `DefaultApplication` makes the calls.

---

## Contracts

| Interface | Implementation | Purpose |
| --- | --- | --- |
| `Contract\ErrorHandlingServiceInterface` | `Service\DefaultErrorHandlingService` | Installs and restores the error handler, and reports errors raised before the script ran. |
| `Contract\ErrorHandlingServiceFactoryInterface` | `Factory\DefaultErrorHandlingServiceFactory` | Creates the service with the strict handler. |
| `Contract\ErrorHandlerInterface` | `Service\StrictErrorExceptionThrower` | The callback given to `set_error_handler()`. |

Namespaces are relative to `WebServCo\Error\`.

---

## Notes

`StrictErrorExceptionThrower` throws for every error, including notices, errors silenced with `@` and levels excluded by `error_reporting`. The exception code is 500.

`initialize()` also sets `display_errors` to `0`. This has no effect on fatal errors in the script itself, because those happen before any code runs.

`handlePreExecutionErrors()` throws an `ErrorException` if `error_get_last()` has an error. The exception code says what kind of error it was: 1 for a POST body over `post_max_size`, 500 for anything else.

---

## Development

```shell
# Start project.
ddev start
# Install dependencies.
ddev c u
# Run all validations.
ddev c c
# Run unit tests.
ddev c test:dox
```

---

## License

[MIT](LICENSE.md)
