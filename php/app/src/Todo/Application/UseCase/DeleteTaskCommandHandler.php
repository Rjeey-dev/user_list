<?php
declare(strict_types=1);

namespace App\Todo\Application\UseCase;

use App\Todo\Application\Command\DeleteTaskCommand;
use App\Todo\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class DeleteTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;

    public function __construct(TasksRepositoryInterface $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function __invoke(DeleteTaskCommand $command): void
    {
        $task = $this->tasksRepository->get($command->getId());

        $task->delete();

        $this->tasksRepository->remove($task);
    }
}
