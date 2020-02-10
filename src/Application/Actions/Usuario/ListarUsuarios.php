<?php

declare(strict_types=1);

  namespace App\Application\Actions\Usuario;

  use Psr\Http\Message\ResponseInterface as Response;
  class ListarUsuarios extends UsuarioAction
  {
   protected function action(): Response
   {
       $usuario = $this->usuarioRepository->ListarUsuarios();

       return $this->respondWithData($usuario);
   }
   
  }
