<?php

declare(strict_types=1);

namespace WebServCo\Error\Factory;

use WebServCo\Error\Contract\ErrorHandlingServiceFactoryInterface;
use WebServCo\Error\Contract\ErrorHandlingServiceInterface;
use WebServCo\Error\Service\DefaultErrorHandlingService;
use WebServCo\Error\Service\StrictErrorExceptionThrower;

final class DefaultErrorHandlingServiceFactory implements ErrorHandlingServiceFactoryInterface
{
    public function createErrorHandlingService(): ErrorHandlingServiceInterface
    {
        return new DefaultErrorHandlingService(new StrictErrorExceptionThrower());
    }
}
