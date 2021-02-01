<?php
declare(strict_types=1);

namespace App\User\Presentation\Controller;

use App\Kernel\Api\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends ApiController
{
    /**
     * @Route("/lists", name="list", methods={"GET"})
     */
  public function lists (Request $request): Response
  {
        $number = "FDSFDSF";
        return new Response($number);
  }
}

