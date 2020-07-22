<?php
declare(strict_types=1);

namespace App\Todo\Infrastructure\Persistence\Doctrine\ODM\Types;

use App\Todo\Domain\ValueObject\TaskId;
use Doctrine\ODM\MongoDB\Types\Type;

class TaskIdType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value)
    {
        return $value === null ? null : new TaskId((string) $value);
    }

    public function closureToPHP(): string
    {
        return '$return = new \App\Todo\Domain\ValueObject\TaskId((string) $value);';
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value)
    {
        if ($value === null || !$value instanceof TaskId) {
            return $value;
        }

        return $value->getId();
    }
}
