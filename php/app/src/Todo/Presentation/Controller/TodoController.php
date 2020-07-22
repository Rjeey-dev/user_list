<?php
declare(strict_types=1);

namespace App\Todo\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\Todo\Application\Command\CreateTaskCommand;
use App\Todo\Application\Command\DeleteTaskCommand;
use App\Todo\Application\Command\UpdateTaskCommand;
use App\Todo\Application\Query\FindTaskByIdQuery;
use App\Todo\Application\Query\FindTasksQuery;
use App\Todo\Domain\DTO\TasksList;
use App\Todo\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends ApiController
{
    /**
     * @Route("/api/v1/tasks", name="tasks_list", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        try {
            /** @var TasksList $tasksList */
            $tasksList = $this->queryBus->handle(new FindTasksQuery(
                $request->query->get('offset') ? (string) $request->query->get('offset') : null,
                $request->query->get('limit') ? (string) $request->query->get('limit') : null,
                $request->query->get('order') ? (string) $request->query->get('order') : null
            ));

            return $this->buildSerializedListResponse(
                $tasksList->getTasks(),
                $tasksList->getTotalCount(),
                ['tasks-list']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route("/api/v1/tasks", name="task_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new CreateTaskCommand(
                (string) $data['text']
            );

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindTaskByIdQuery($command->getId()->getId())),
                ['task-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/api/v1/tasks/{id}", name="task_detail", methods={"GET"})
     */
    public function detail(Request $request, string $id): Response
    {
        try {
            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindTaskByIdQuery($id)),
                ['task-detail']
            );
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route("/api/v1/tasks/{id}", name="task_update", methods={"PATCH"})
     */
    public function update(Request $request, string $id): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new UpdateTaskCommand($id, (string) $data['text']);

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindTaskByIdQuery($id)),
                ['task-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }

    /**
     * @Route("/api/v1/tasks/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(string $id): Response
    {
        try {
            $command = new DeleteTaskCommand($id);

            $this->commandBus->handle($command);

            return $this->buildSuccessResponse();
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }
}
