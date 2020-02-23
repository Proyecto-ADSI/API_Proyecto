<?php 

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerUsuario extends UsuarioAction{

    protected function action(): Response
   {

        $Id_Usuario = $this->resolveArg("usuario");

        $Id_Usuario = (int) $Id_Usuario; 

        $usuario = $this->usuarioRepository->ObtenerUsuario($Id_Usuario);

       return $this->respondWithData($usuario);
   }
   
}





 