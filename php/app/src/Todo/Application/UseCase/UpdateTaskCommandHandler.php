<?php
declare(strict_types=1);

namespace App\Todo\Application\UseCase;

use App\Todo\Application\Command\UpdateTaskCommand;
use App\Todo\Domain\Repository\TasksRepositoryInterface;
use NinjaBuggs\ServiceBus\Command\UseCaseInterface;
use NinjaBuggs\ServiceBus\TransactionalHandlerInterface;

class UpdateTaskCommandHandler implements UseCaseInterface, TransactionalHandlerInterface
{
    private $tasksRepository;

    public function __construct(TasksRepositoryInterface $tasksRepository)
    {
        $this->tasksRepository = $tasksRepository;
    }

    public function __invoke(UpdateTaskCommand $command): void
    {
        $task = $this->tasksRepository->get($command->getId());

        $task->update($command->getText());

        $this->tasksRepository->add($task);
    }
}
