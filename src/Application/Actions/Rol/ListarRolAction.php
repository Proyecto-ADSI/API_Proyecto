<?php

declare(strict_types=1);

namespace App\Application\Actions\Rol;

use Psr\Http\Message\ResponseInterface as Response;

class ListarRolAction extends RolAction
{
  protected function action(): Response
  {
    $Rol = $this->RolRepository->ListarRol();
    return $this->respondWithData($Rol);
  }
}
