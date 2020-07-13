<?php

declare (strict_types = 1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ListarAsignacionAction extends ClienteAction
{
    protected function action(): Response
    {   
        $arrayRespuesta = [];
        $infoAsignacion = $this->AsignacionERepository->ObtenerCantidadEmpresasContact();
        foreach($infoAsignacion as $item){
            $Id_Usuario = (int) $item['Id_Usuario'];
            $infoUsuario = $this->UsuarioRepository->ObtenerUsuario($Id_Usuario);
            $idEmpresas = $this->AsignacionERepository->ListarEmpresasContact($Id_Usuario);

            $infoEmpresas = [];
            foreach($idEmpresas as $idEmpresa){
                $Id_Cliente = (int) $idEmpresa['Id_Cliente'];
                $infoEmpresa = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
                array_push($infoEmpresas,$infoEmpresa);
            }

            $infoRespuesta = [
                "Id_Usuario" => $Id_Usuario,
                "Usuario" => $infoUsuario['Usuario'],
                "Imagen" => $infoUsuario['Imagen'],
                "Celular" => $infoUsuario['Celular'],
                "Nombre" => $infoUsuario['Nombre'] . " " . $infoUsuario['Apellidos'],
                "Imagen" => $infoUsuario['Imagen'],
                "Cantidad_Empresas" => $item["Cantidad"],
                "Empresas" => $infoEmpresas
            ];
            array_push($arrayRespuesta,$infoRespuesta);
        } 
        return $this->respondWithData($arrayRespuesta);
    }
}
