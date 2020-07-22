<?php
declare(strict_types=1);

namespace App\Todo\Infrastructure\Persistence\Doctrine\ODM\DataProvider;

use App\Kernel\Doctrine\DocumentRepository;
use App\Todo\Domain\DataProvider\TasksDataProviderInterface;
use App\Todo\Domain\DTO\Task;
use App\Todo\Domain\DTO\TasksList;
use App\Todo\Domain\Entity\Task as TaskEntity;
use App\Todo\Domain\Exception\TaskNotFoundException;
use App\Todo\Domain\ValueObject\TaskId;

class TasksDataProvider extends DocumentRepository implements TasksDataProviderInterface
{
    public function findTask(TaskId $id): Task
    {
        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class)
            ->field('id')->equals($id->getId())
            ->hydrate(false)
            ->getQuery();

        if (!$task = $query->getSingleResult()) {
            throw new TaskNotFoundException(sprintf('Task %s not found', $id->getId()));
        }

        return $this->createTask($task);
    }

    public function findTasks(int $offset, int $limit, string $order): TasksList
    {
        $tasksResult = [];

        $query = $this->getDocumentManager()->createQueryBuilder(TaskEntity::class);
        $query->skip($offset);
        $query->limit($limit);
        $query->sort('created', $order);

        $query = $query->hydrate(false)
            ->getQuery();

        foreach ($query->execute() as $task) {
            $tasksResult[] = $this->createTask($task);
        }

        return new TasksList($tasksResult, count($tasksResult));
    }

    private function createTask(array $task): Task
    {
        return new Task(
            $task['_id'],
            $task['text'],
            \DateTimeImmutable::createFromMutable($task['created']->toDateTime()),
        );
    }
}
