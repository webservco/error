<?php

declare(strict_types=1);

namespace WebServCo\Error\Contract;

interface ErrorHandlingServiceFactoryInterface
{
    public function createErrorHandlingService(): ErrorHandlingServiceInterface;
}
