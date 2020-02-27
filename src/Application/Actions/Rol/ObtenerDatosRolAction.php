<?php

declare(strict_types=1);

  namespace App\Application\Actions\Rol;

  use Psr\Http\Message\ResponseInterface as Response;

  class ObtenerDatosRolAction extends RolAction
  {
   protected function action(): Response
   {

       $Id_Rol= $this->resolveArg("Id_Rol");

       $Rol = $this->RolRepository->ObtenerDatosRol($Id_Rol);

       return $this->respondWithData($Rol);
   }
   
  }
