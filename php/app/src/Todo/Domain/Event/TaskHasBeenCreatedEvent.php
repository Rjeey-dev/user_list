<?php
declare(strict_types=1);

namespace App\Todo\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class TaskHasBeenCreatedEvent implements EventInterface
{
    private $id;
    private $text;

    public function __construct(string $id, string $text)
    {
        $this->id = $id;
        $this->text = $text;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
