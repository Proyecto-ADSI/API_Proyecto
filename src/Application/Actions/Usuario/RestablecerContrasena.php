<?php

declare(strict_types= 1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class RestablecerContrasena extends UsuarioAction
{
    protected function action(): Response
    {
        $campos  = $this->getFormData();

        $Id_Usuario = $campos->Id_Usuario;
        $Contrasena = $campos->Contrasena;


        $this->usuarioRepository->RestablecerContrasena($Id_Usuario,$Contrasena);

        $token = $this->usuarioRepository->EliminarToken($Id_Usuario);

        return $this->respondWithData(["ok"=> $token]);
    }
}