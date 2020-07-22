<?php
declare(strict_types=1);

namespace App\Todo\Domain\Repository;

use App\Todo\Domain\Entity\Task;
use App\Todo\Domain\Exception\TaskNotFoundException;
use App\Todo\Domain\ValueObject\TaskId;

interface TasksRepositoryInterface
{
    /**
     * @throws TaskNotFoundException
     */
    public function get(TaskId $id): Task;
    public function add(Task $task): void;
    public function remove(Task $task): void;
}
