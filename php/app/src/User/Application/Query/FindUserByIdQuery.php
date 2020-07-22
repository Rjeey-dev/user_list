<?php
declare(strict_types=1);

namespace App\User\Application\Query;

use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindUserByIdQuery implements QueryInterface
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
