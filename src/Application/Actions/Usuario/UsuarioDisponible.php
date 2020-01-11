<?php

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class UsuarioDisponible extends UsuarioAction
{
    protected function action(): Response
    {
        $usuario  = $this->request->getQueryParams();

        // $usuario = $this->getFormData();

        // return $this->respondWithData($usuario);

        // return $this->respondWithData($usuario['txtUsuario']);

        $respuesta = $this->usuarioRepository->ValidarUsuario($usuario['txtUsuario']);

        if($respuesta){
            return $this->respondWithData(false);
        }else{  
            return $this->respondWithData(true);
        }
    }
}

