<?php
declare(strict_types=1);

namespace App\Todo\Application\Command;

use App\Todo\Domain\ValueObject\TaskId;
use NinjaBuggs\ServiceBus\Command\CommandInterface;

class DeleteTaskCommand implements CommandInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = new TaskId($id);
    }

    public function getId(): TaskId
    {
        return $this->id;
    }
}
