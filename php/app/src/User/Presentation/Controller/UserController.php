<?php
declare(strict_types=1);

namespace App\User\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use App\Kernel\Api\Response\ApiResponse;
use App\User\Application\Command\CreateUserCommand;
use App\User\Application\Query\FindUserByIdQuery;
use App\User\Application\Query\FindUsersQuery;
use App\User\Domain\DTO\UsersList;
use App\User\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;


class UserController extends ApiController
{
    /**
     * @Route("/lists", name="list", methods={"GET"})
     */
    public function list(Request $request): Response
    {
        try {
            /** @var UsersList $usersList */
            $usersList = $this->queryBus->handle(new FindUsersQuery(
                $request->query->get('offset') ? (string)$request->query->get('offset') : null,
                $request->query->get('limit') ? (string)$request->query->get('limit') : null,
                $request->query->get('order') ? (string)$request->query->get('order') : null
            ));

            return $this->buildSerializedListResponse(
                $usersList->getTasks(),
                $usersList->getTotalCount(),
                ['users-list']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse();
        }
    }

    /**
     * @Route ("/create_user", name="create_user", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            $command = new CreateUserCommand(
                (string)$data['text'],
                (string)$data['name']
            );

            $this->commandBus->handle($command);

            return $this->buildSerializedResponse(
                $this->queryBus->handle(new FindUserByIdQuery($command->getId()->getId()))
                ['user-detail']
            );
        } catch (ValidationException $e) {
            return $this->buildFailResponse(ApiResponse::ERROR_VALIDATION_FAILED);
        } catch (\Throwable $e) {
            return $this->buildFailResponse($e->getMessage());
        }
    }
}

