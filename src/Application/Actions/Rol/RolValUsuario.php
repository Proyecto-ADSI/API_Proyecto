<?php

declare(strict_types=1);

  namespace App\Application\Actions\Rol;

  use Psr\Http\Message\ResponseInterface as Response;

  class RolValUsuario extends RolAction
  {
   protected function action(): Response
   {

       $Id_Rol= (int) $this->resolveArg("Id_Rol");

       $Rol = $this->RolRepository->RolValUsuario($Id_Rol);

       return $this->respondWithData($Rol);
   }
   
  }