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

        // $this->logger->info("Producto of qweed ".json_encode($respuesta)." was viewed.");
        
        if(!$respuesta)
        {
            return  $this->respondWithData(["ok"=> false]);

        }else{

            // $datos = json_encode($respuesta);

            if($contrasena == $respuesta['Contrasena'] ){

                return $this->respondWithData([
                    "ok"=>true,
                    "Id_Usuario"=>$respuesta['Id_Usuario'],
                    "Usuario"=>$respuesta['Usuario'],
                    "Rol"=>$respuesta['Id_Rol']
                ]);
                    
            }else{

                return  $this->respondWithData(["ok"=> false]);
            }
        }
    }
}
