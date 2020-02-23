<?php

declare(strict_types = 1);

namespace App\Application\Actions\Usuario;

use App\Domain\Empleado\Empleado;
use App\Domain\Usuario\Usuario;
use Psr\Http\Message\ResponseInterface as Response; 

class EditarUsuario extends UsuarioAction
{
    protected function action(): Response
    {
        $datos = $this->getFormData();


        $empleado = new Empleado(
            $datos->Id_Empleado,
            $datos->Tipo_Documento,
            $datos->Documento,
            $datos->Nombre,
            $datos->Apellidos,
            $datos->Correo,
            $datos->Sexo,
            $datos->Celular,
            $datos->Imagen,
            $datos->Turno,
        );

        $this->EmpleadoRepository->EditarEmpleado($empleado);

        $usuario = new Usuario(
            $datos->Id_Usuario,
            $datos->Id_Empleado,
            $datos->Usuario,
            '',
            $datos->Rol,
        );

        $res = $this->usuarioRepository->EditarUsuario($usuario);

        return $this->respondWithData(["ok"=> $res]);
        

    }
}

