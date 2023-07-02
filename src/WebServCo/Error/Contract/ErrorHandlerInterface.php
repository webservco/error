<?php

declare(strict_types=1);

namespace WebServCo\Error\Contract;

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
