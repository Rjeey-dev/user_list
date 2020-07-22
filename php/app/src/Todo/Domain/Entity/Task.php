<?php
declare(strict_types=1);

namespace App\Todo\Domain\Entity;

use App\Todo\Domain\Event\TaskHasBeenCreatedEvent;
use App\Todo\Domain\Event\TaskHasBeenDeletedEvent;
use App\Todo\Domain\Event\TaskHasBeenUpdateEvent;
use App\Todo\Domain\ValueObject\TaskId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class Task implements EventRecordableInterface
{
    use EventRecordableTrait;

    /**
     * @MongoDB\Id(strategy="NONE", type="todo:task_id")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(TaskId $id, string $text)
    {
        $this->id = $id;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new TaskHasBeenCreatedEvent(
            $id->getId(),
            $text
        ));
    }

    public function update(string $text): void
    {
        $this->text = $text;

        $this->recordEvent(new TaskHasBeenUpdateEvent(
            $this->id->getId(),
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new TaskHasBeenDeletedEvent(
            $this->id->getId(),
            $this->text
        ));
    }
}