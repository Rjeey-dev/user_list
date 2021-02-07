<?php
declare(strict_types=1);

namespace App\User\Domain\Entity;

use App\User\Domain\Event\UserHasBeenCreatedEvent;
use App\User\Domain\Event\UserHasBeenUpdateEvent;
use App\User\Domain\Event\UserHasBeenDeletedEvent;
use App\User\Domain\ValueObject\UserId;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use NinjaBuggs\ServiceBus\Event\EventRecordableInterface;
use NinjaBuggs\ServiceBus\Event\EventRecordableTrait;

/**
 * @MongoDB\Document
 */
class User implements EventRecordableInterface
{
    use EventRecordableTrait;

    /**
     * @MongoDB\Id(strategy="NONE", type="todo:task_id")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $username;

    /**
     * @MongoDB\Field(type="string")
     */
    private $text;

    /**
     * @MongoDB\Field(type="date_immutable")
     */
    private $created;

    public function __construct(UserId $id, string $username, string $text)
    {
        $this->id = $id;
        $this->username = $username;
        $this->text = $text;
        $this->created = new \DateTimeImmutable();

        $this->recordEvent(new UserHasBeenCreatedEvent(
            $id->getId(),
            $username,
            $text

        ));
    }

    public function update(string $text, string $username): void
    {
        $this->username = $username;
        $this->text = $text;

        $this->recordEvent(new UserHasBeenUpdateEvent(
            $this->id->getId(),
            $username,
            $text
        ));
    }

    public function delete(): void
    {
        $this->recordEvent(new UserHasBeenDeletedEvent(
            $this->id->getId(),
            $this->username,
            $this->text
        ));
    }
}