<?php

declare(strict_types=1);

namespace WebServCo\Error\Service;

use ErrorException;
use WebServCo\Error\Contract\ErrorHandlerInterface;
use WebServCo\Error\Contract\ErrorHandlingServiceInterface;

use function error_clear_last;
use function error_get_last;
use function ini_set;
use function restore_error_handler;
use function set_error_handler;
use function strpos;

/**
 * Error handling service.
 *
 * Steps:
 * - inititalize
 * - handlePreExecutionErrors
 * - restore
 */
final class DefaultErrorHandlingService implements ErrorHandlingServiceInterface
{
    public function __construct(private ErrorHandlerInterface $handler)
    {
    }

    /**
     * Handle error that happened before script execution.
     *
     * Throws ErrorException if such an error exists.
     * Should be called by application bootstrap code,
     * after exception handler initialization
     * and before execution of actual application logic.
     */
    public function handlePreExecutionErrors(): bool
    {
        $error = error_get_last();

        if ($error === null) {
            return false;
        }

        // Make sure error is not reported again.
        error_clear_last();

        throw new ErrorException(
            $error['message'],
            $this->getPreExecutionErrorCode($error['message']),
            // severity
            $error['type'],
            $error['file'],
            $error['line'],
            // previous
            null,
        );
    }

    public function initialize(): bool
    {
        /**
         * Note.
         *
         * "[..] it won't have any effect if the script has fatal errors."
         * "This is because the desired runtime action does not get executed."
         */
        ini_set('display_errors', '0');

        set_error_handler([$this->handler, 'handle']);

        return true;
    }

    public function restore(): bool
    {
        return restore_error_handler();
    }

    private function getPreExecutionErrorCode(string $errorMessage): int
    {
        return strpos($errorMessage, 'POST Content-Length of ') !== false
            /**
             * Handle: "Error: POST Content-Length of X bytes exceeds the limit of Y bytes in Unknown:0."
             * https://www.php.net/manual/en/features.file-upload.errors.php
             * UPLOAD_ERR_INI_SIZE
             */
            ? 1
            // default
            : 500;
    }
}
