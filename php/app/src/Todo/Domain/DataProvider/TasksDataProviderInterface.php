<?php
declare(strict_types=1);

namespace App\Todo\Domain\DataProvider;

use App\Todo\Domain\DTO\Task;
use App\Todo\Domain\DTO\TasksList;
use App\Todo\Domain\Exception\TaskNotFoundException;
use App\Todo\Domain\ValueObject\TaskId;

interface TasksDataProviderInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function findTask(TaskId $id): Task;
    public function findTasks(int $offset, int $limit, string $order): TasksList;
}
