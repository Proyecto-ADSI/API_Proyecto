<?php

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarUsuario extends UsuarioAction
{
    protected function action(): Response
    {
        $usuario  = $this->resolveArg("usuario");
        
        $respuesta = $this->usuarioRepository->ValidarUsuario($usuario);

        if($respuesta){
            return $this->respondWithData(["ok"=>true,"Email"=> $respuesta['Email']]);
        }else{
            return $this->respondWithData(["ok"=>false]);
        }
    }
}

