<?php
declare(strict_types=1);

namespace App\User\Domain\Event;

use NinjaBuggs\ServiceBus\Event\EventInterface;

class UserHasBeenDeletedEvent implements EventInterface
{
    private $id;
    private $username;
    private $text;

    public function __construct(string $id, string $username, string $text)
    {
        $this->id = $id;
        $this->username = $username;
        $this->text = $text;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->username;
    }

    public function getText(): string
    {
        return $this->text;
    }
}