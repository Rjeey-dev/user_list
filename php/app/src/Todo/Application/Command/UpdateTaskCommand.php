<?php
declare(strict_types=1);

namespace App\Todo\Application\Command;

use App\Todo\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class UpdateTaskCommand implements CommandInterface
{
    private $id;
    private $text;

    public function __construct(string $id, string $text)
    {
        $this->id = new TaskId($id);
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
