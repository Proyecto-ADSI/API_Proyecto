<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarContrasenaPerfilAction extends UsuarioAction{

    protected function action(): Response
    {

        $Campos = $this->getFormData();

        $Id_Usuario = $Campos->Id_Usuario;

        $Contrasena = password_hash($Campos->Contrasena,PASSWORD_BCRYPT);

        $Response = $this->usuarioRepository->RestablecerContrasena($Id_Usuario, $Contrasena);
        
        return $this->respondWithData(["Ok"=> $Response]);
    }

}