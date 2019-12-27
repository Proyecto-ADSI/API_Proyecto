<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use App\Domain\Empleado\Empleado;
use App\Domain\Usuario\Usuario;
use Psr\Http\Message\ResponseInterface as Response;

class UsuarioRegistro extends UsuarioAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $usuario = new Usuario(
            0,
            $campos->Usuario,
            $campos->Contrasena,
            $campos->Id_Rol
        );

        $this->usuarioRepository->RegistrarUsuario($usuario);
        

        $ultimo = $this->usuarioRepository->ConsultarUltimoUsuario();

        // return $this->respondWithData(["ok"=> $ultimo]);

        $empleado = new Empleado(
            0,
            (int)$ultimo['Id_Usuario'],
            $campos->Documento,
            $campos->Nombre,
            $campos->Apellido,
            $campos->Email,
            $campos->Sexo,
            $campos->Turno
        );

        $datos = $this->EmpleadoRepository->RegistrarEmpleado($empleado);



        return $this->respondWithData(["ok"=> $datos]);

    }
}

