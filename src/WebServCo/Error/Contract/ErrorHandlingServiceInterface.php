<?php

declare(strict_types=1);

namespace WebServCo\Error\Contract;

interface ErrorHandlingServiceInterface
{
    public function handlePreExecutionErrors(): bool;

    public function initialize(): bool;

    public function restore(): bool;
}
