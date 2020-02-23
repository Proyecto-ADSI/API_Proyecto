<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Domain\Cliente\Cliente;
use Psr\Http\Message\ResponseInterface as Response;

class ClienteRegistro extends ClienteAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();
        
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
        
        return $this->respondWithData(["usuario" => $usuario, "ok"=> $respuesta, ]);
    }
}

