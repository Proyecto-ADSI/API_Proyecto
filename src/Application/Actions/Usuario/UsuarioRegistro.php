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
        
        if(isset($campos->Id_Empleado)){
            
           $Id_Empleado = (int)$campos->Id_Empleado;

        }else{

            $empleado = new Empleado(
                0,
                $campos->Tipo_Documento,
                $campos->Documento,
                $campos->Nombre,
                $campos->Apellidos,
                $campos->Email,
                $campos->Sexo,
                $campos->Celular,
                $campos->Imagen,
                $campos->Turno
            );
    
            $this->EmpleadoRepository->RegistrarEmpleado($empleado);
            
            $respuesta = $this->EmpleadoRepository->ConsultarUltimoEmpleado();
            $Id_Empleado = (int) $respuesta['Id_Empleado'];
        }
        
        //Encriptar contraseña
        $Contrasena = password_hash($campos->Contrasena,PASSWORD_BCRYPT);

        $usuario = new Usuario(
            0,
            $Id_Empleado,
            $campos->Usuario,
            $Contrasena,
            $campos->Rol
        );

        $respuesta = $this->usuarioRepository->RegistrarUsuario($usuario);
        
        return $this->respondWithData(["ok"=> $respuesta]);
    }
}

