<?php
declare(strict_types=1);

namespace App\User\Application\EventUseCase;

use App\Todo\Domain\Event\TaskHasBeenCreatedEvent;
use NinjaBuggs\ServiceBus\Event\EventUseCaseInterface;

class AddTaskToUserOnTaskHasBeenCreatedEventHandler implements EventUseCaseInterface
{
    public function __invoke(TaskHasBeenCreatedEvent $event): void
    {
        // TODO Implement how we should handle this event.
    }
}
