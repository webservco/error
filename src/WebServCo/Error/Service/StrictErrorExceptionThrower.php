<?php

declare(strict_types=1);

namespace WebServCo\Error\Service;

use ErrorException;
use WebServCo\Error\Contract\ErrorHandlerInterface;

use function error_clear_last;

/**
 * A strict ErrorException thrower.
 *
 * Throws ErrorException for any error, regardless of type and level.
 * Ignore error reporting disabled or suppressed.
 */
final class StrictErrorExceptionThrower implements ErrorHandlerInterface
{
    public function handle(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        // Make sure error is not reported again.
        error_clear_last();

        throw new ErrorException(
            // message
            $errstr,
            // code
            500,
            // severity
            $errno,
            // filename
            $errfile,
            // line
            $errline,
            // previous
            null,
        );
    }
}
