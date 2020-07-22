<?php
declare(strict_types=1);

namespace App\Todo\Application\QueryUseCase;

use App\Todo\Application\Query\FindTasksQuery;
use App\Todo\Domain\DataProvider\TasksDataProviderInterface;
use App\Todo\Domain\DTO\TasksList;
use NinjaBuggs\ServiceBus\Query\QueryUseCaseInterface;

class FindTasksQueryHandler implements QueryUseCaseInterface
{
    private $tasksDataProvider;

    public function __construct(TasksDataProviderInterface $tasksDataProvider)
    {
        $this->tasksDataProvider = $tasksDataProvider;
    }

    public function __invoke(FindTasksQuery $query): TasksList
    {
        return $this->tasksDataProvider->findTasks($query->getOffset(), $query->getLimit(), $query->getOrder());
    }
}
