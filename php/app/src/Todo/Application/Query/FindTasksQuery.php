<?php
declare(strict_types=1);

namespace App\Todo\Application\Query;

use App\Todo\Domain\Exception\ValidationException;
use NinjaBuggs\ServiceBus\Query\QueryInterface;

class FindTasksQuery implements QueryInterface
{
    private const DEFAULT_OFFSET = 0;
    private const DEFAULT_LIMIT = 20;
    private const MAX_LIMIT = 40;
    private const DEFAULT_ORDER = 'ASC';
    private const ORDER_DESC = 'DESC';

    private const SUPPORTED_ORDERS = [
        self::DEFAULT_ORDER,
        self::ORDER_DESC,
    ];

    private $offset;
    private $limit;
    private $order;

    /**
     * @throws ValidationException
     */
    public function __construct(?int $offset, ?int $limit, ?string $order)
    {
        $offset = $offset ?? self::DEFAULT_OFFSET;
        $limit = $limit ?? self::DEFAULT_LIMIT;
        $order = $order ?? self::DEFAULT_ORDER;

        $this->validateOffset($offset);
        $this->validateLimit($limit);
        $this->validateOrder($order);

        $this->offset = $offset;
        $this->limit = $limit;
        $this->order = $order;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @throws ValidationException
     */
    private function validateOffset(int $offset): void
    {
        if ($offset < 0) {
            throw new ValidationException('Offset should be positive');
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateLimit(int $limit): void
    {
        if ($limit < 0) {
            throw new ValidationException('Limit should be positive');
        }

        if ($limit > self::MAX_LIMIT) {
            throw new ValidationException('Limit should not be more than 40');
        }
    }

    /**
     * @throws ValidationException
     */
    private function validateOrder(string $order): void
    {
        if (!in_array($order, self::SUPPORTED_ORDERS, true)) {
            throw new ValidationException('Order should be ASC or DESC');
        }
    }
}
