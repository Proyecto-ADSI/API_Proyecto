<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ValidarCliente extends ClienteAction
{
    protected function action(): Response
    {
        $params = $this->request->getQueryParams();
        $texto = $params['texto'];
        
        // Validar si cliente está registrado.
        $res = $this->ClienteRepository->ValidarCliente($texto);

        if ($res) {
            // Validar si la petición viene de módulo llamada o de cliente.
            if(isset($params['Id_Usuario'])){
                $Id_Usuario = (int) $params['Id_Usuario'];
                $Id_Cliente = (int) $res['Id_Cliente'];
                $cliente = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
                // Validar si está habilitado 
                $Estado_Cliente =   (int) $cliente['Estado_Cliente'];
                if ($Estado_Cliente == 1) {
                    return $this->respondWithData(["ok" => false, "llamar" => true, "cliente" => $cliente]);
                } else if ($Estado_Cliente == 0) {
                    // Validar si empresa está asignada
                    $res = $this->AsignacionERepository->ValidarSiEmpresaAsignada($Id_Cliente);
                    $Asignada = (int) $res['Asignada'];
                    if ($Asignada > 0) {
                        // Validar si está asignado al usuario que origina validación.
                        $res  = $this->AsignacionERepository->ValidarEmpresaAsignadaContact($Id_Usuario, $Id_Cliente);
                        $Asignada = (int) $res['Asignada'];
                        if ($Asignada == 1) {
                            return $this->respondWithData(["ok" => false, "llamar" => true, "cliente" => $cliente]);
                        } else {
                            $razones = "Cliente asignado a otro usuario";
                            return $this->respondWithData(["ok" => false, "llamar" => false, "cliente" => $cliente, "razones" => $razones]);
                        }
                    }else{
                        $razones = "Cliente con proceso activo";
                        return $this->respondWithData(["ok" => false, "llamar" => false, "cliente" => $cliente, "razones" => $razones]);
                    }
                }
                else {
                    $razones = "No es una empresa.";
                    return $this->respondWithData(["ok" => false, "llamar" => false, "cliente" => $cliente, "razones" => $razones]);
                }
            }else{
                return $this->respondWithData(["ok" => false]);
            }
        } else {
            return $this->respondWithData(["ok" => true]);
        }
    }
}
