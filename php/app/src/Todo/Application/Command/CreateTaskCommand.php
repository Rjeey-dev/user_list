<?php
declare(strict_types=1);

namespace App\Todo\Application\Command;

use App\Todo\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class CreateTaskCommand implements CommandInterface
{
    private $id;
    private $text;

    public function __construct(string $text)
    {
        $this->id = TaskId::generate();
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}
