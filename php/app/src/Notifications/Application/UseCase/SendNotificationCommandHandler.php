<?php
declare(strict_types=1);

namespace App\Notifications\Application\UseCase;

use App\Notifications\Application\Command\SendNotificationCommand;
use App\User\Application\Query\FindUserByIdQuery;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\Query\QueryBusInterface;

class SendNotificationCommandHandler implements UseCaseInterface
{
    private $queryBus;

    public function __construct(QueryBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function __invoke(SendNotificationCommand $command): void
    {
        /*
         * Use query bus to get information from another context. Return value can be scalar or simple DTO
         */
        $user = $this->queryBus->handle(new FindUserByIdQuery($command->getId()));

        // TODO Realize how we should handle command
    }
}
