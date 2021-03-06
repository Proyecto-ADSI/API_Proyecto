<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends UsuarioAction
{
    protected function action(): Response
    {
        $Campos = $this->getFormData();

        $usuario = $Campos->Usuario;
        $contrasena = $Campos->Contrasena;

        $respuesta = $this->usuarioRepository->login($usuario);

        if (!$respuesta) {
            return  $this->respondWithData(["ok" => false]);
        } else {

            // Validar si el hash y la contraseña coinciden

            if (password_verify($contrasena, $respuesta['Contrasena'])) {

                return $this->respondWithData([
                    "ok" => true,
                    "Id_Usuario" => $respuesta['Id_Usuario'],
                    "Usuario" => $respuesta['Usuario'],
                    "Nombre" => $respuesta['Nombre'],
                    "Id_Rol" => $respuesta['Id_Rol'],
                    "Rol" => $respuesta['Rol'],
                    "Email" => $respuesta['Email'],
                    "Imagen" => $respuesta['Imagen']
                ]);
            } else {
                return  $this->respondWithData(["ok" => false]);
            }
        }
    }
}
