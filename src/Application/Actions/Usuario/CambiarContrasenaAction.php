<?php

declare (strict_types=1);

namespace App\Application\Actions\Usuario;
use Psr\Http\Message\ResponseInterface as Response;

class CambiarContrasenaAction extends UsuarioAction {

    protected function action(): Response
    {
        $Parametros = $this->request->getQueryParams();

        $Usuario = $Parametros['Usuario'];
        $Contrasena = $Parametros['ContrasenaAc'];

        $ResLogin = $this->usuarioRepository->login($Usuario);
        $ContrasenaLogin = $ResLogin['Contrasena'];

        $ValidarContra = password_verify($Contrasena, $ContrasenaLogin);

        if ($ValidarContra) {
            
            return $this->respondWithData(["Ok" => true]);
            
        }
        else{
           
        return $this->respondWithData(["Ok" => false]);

        }
    }
}