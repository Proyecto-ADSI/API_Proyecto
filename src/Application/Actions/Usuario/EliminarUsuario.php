<?php

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
class EliminarUsuario extends UsuarioAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int)$this->resolveArg('Id_Usuario_Eliminar');

        $r = $this->usuarioRepository->ValidarEliminarUsuario($Id_Usuario);

        // Validar si variable tiene algún registro
        // Devuelve true si $r tiene algún registro
        if(!empty($r)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $r = $this->usuarioRepository->EliminarUsuario($Id_Usuario);

            return $this->respondWithData(["Eliminar" => $r]);
        }
       
    }

}