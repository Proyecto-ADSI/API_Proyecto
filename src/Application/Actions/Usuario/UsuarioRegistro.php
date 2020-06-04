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

        $Id_Empleado = NULL;

        if ($campos->SeleccionarEmpleado) {

            $Id_Empleado = (int) $campos->Id_Empleado;
        } else {

            $empleado = new Empleado(
                0,
                null,
                null,
                $campos->Nombre,
                null,
                $campos->Email,
                null,
                null,
                $campos->Imagen,
                null,
            );

            if ($campos->RegistrarEmpleado) {

                $empleado->__set("Apellidos", $campos->Apellidos);
                $empleado->__set("Tipo_Documento", $campos->Tipo_Documento);
                $empleado->__set("Documento", $campos->Documento);
                $empleado->__set("Sexo", $campos->Sexo);
                $empleado->__set("Celular", $campos->Celular);
                $empleado->__set("Turno", $campos->Turno);

                $this->EmpleadoRepository->RegistrarEmpleado($empleado);
                $respuesta = $this->EmpleadoRepository->ConsultarUltimoEmpleado();
                $Id_Empleado = (int) $respuesta['Id_Empleado'];
            } else if ($campos->RegistrarAsesorExterno) {

                $this->EmpleadoRepository->RegistrarEmpleado($empleado);
                $respuesta = $this->EmpleadoRepository->ConsultarUltimoEmpleado();
                $Id_Empleado = (int) $respuesta['Id_Empleado'];
            }
        }
        //Encriptar contraseña
        $Contrasena = password_hash($campos->Contrasena, PASSWORD_BCRYPT);

        $usuario = new Usuario(
            0,
            $Id_Empleado,
            $campos->Usuario,
            $Contrasena,
            $campos->Rol
        );

        $respuesta = $this->usuarioRepository->RegistrarUsuario($usuario);

        return $this->respondWithData(["ok" => $respuesta]);
    }
}
