<?php
declare(strict_types=1);

namespace App\Todo\Domain\DTO;

use JMS\Serializer\Annotation as Serializer;

class Task
{
    /**
     * @Serializer\SerializedName("id")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $id;

    /**
     * @Serializer\SerializedName("text")
     * @Serializer\Type("string")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $text;

    /**
     * @Serializer\SerializedName("created")
     * @Serializer\Type("DateTimeImmutable")
     * @Serializer\Groups({
     *     "tasks-list",
     *     "task-detail",
     * })
     */
    public $created;

    public function __construct(string $id, string $text, \DateTimeImmutable $created)
    {
        $this->id = $id;
        $this->text = $text;
        $this->created = $created;
    }
}
