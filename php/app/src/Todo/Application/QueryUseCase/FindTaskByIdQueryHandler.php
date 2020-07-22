<?php
declare(strict_types=1);

namespace App\Todo\Application\QueryUseCase;

use App\Todo\Application\Query\FindTaskByIdQuery;
use App\Todo\Domain\DataProvider\TasksDataProviderInterface;
use App\Todo\Domain\DTO\Task;
use App\Todo\Domain\Exception\TaskNotFoundException;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTaskByIdQueryHandler implements QueryUseCaseInterface
{
    private $tasksDataProvider;

    public function __construct(TasksDataProviderInterface $tasksDataProvider)
    {
        $this->tasksDataProvider = $tasksDataProvider;
    }

    public function __invoke(FindTaskByIdQuery $query): ?Task
    {
        try {
            return $this->tasksDataProvider->findTask($query->getId());
        } catch (TaskNotFoundException $e) {
            return null;
        }
    }
}
