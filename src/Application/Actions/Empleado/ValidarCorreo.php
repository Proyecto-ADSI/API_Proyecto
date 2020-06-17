<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarCorreo extends EmpleadoAction
{
    protected function action(): Response
    {
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");

        $info_Usuario = $this->UsuarioRepository->ObtenerUsuario($Id_Usuario);

        $Id_Empleado = (int) $info_Usuario["Id_Empleado"];

        $r = $this->UsuarioRepository->EliminarToken($Id_Usuario);

        $r = $this->EmpleadoRepository->ValidarCorreo($Id_Empleado);

        $r = $this->UsuarioRepository->CambiarEstadoUsuario($Id_Usuario, 1);

        return $this->respondWithData($r);
    }
}
