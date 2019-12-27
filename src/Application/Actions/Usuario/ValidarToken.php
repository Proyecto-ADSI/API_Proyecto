<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarToken extends UsuarioAction
{

   protected function action(): Response
   {

      $token = $this->resolveArg("token");

      $respuesta = $this->usuarioRepository->ValidarToken($token);

      return $this->respondWithData($respuesta);
   }
}
