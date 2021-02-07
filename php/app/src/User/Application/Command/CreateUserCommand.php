<?php
declare(strict_types=1);

namespace App\User\Application\Command;

use App\User\Domain\ValueObject\UserId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    private $id;
    private $username;
    private $text;

    public function __construct(string $username, string $text)
    {
        $this->id = UserId::generate();
        $this->username = $username;
        $this->text = $text;
    }

    public function getName(): string
    {
        return $this->username;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getId(): UserId
    {
        return $this->id;
    }
}