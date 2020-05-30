<?php 

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerUsuarioRol extends UsuarioAction{

    protected function action(): Response
   {

        $Id_Rol = (int)  $this->resolveArg("Id_Rol");
        $res = $this->usuarioRepository->ObtenerUsuarioRol($Id_Rol);

       return $this->respondWithData($res);
   }
   
}
