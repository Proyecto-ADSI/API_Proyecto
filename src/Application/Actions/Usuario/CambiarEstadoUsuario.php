<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoUsuario extends UsuarioAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int) $this->resolveArg('Id_Usuario_CE');

        $Estado = (int) $this->resolveArg('Estado');

        $respuesta = $this->usuarioRepository->CambiarEstadoUsuario($Id_Usuario,$Estado);

        return $this->respondWithData($respuesta);

    }
}