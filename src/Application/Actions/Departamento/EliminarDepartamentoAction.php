<?php

declare(strict_types=1);

namespace App\Application\Actions\Departamento;


use Psr\Http\Message\ResponseInterface as Response;

class EliminarDepartamentoAction extends DepartamentoAction
{
    protected function action(): Response
    {
        $Id_Departamento = (int)$this->resolveArg("Id_Departamento");

        $Validar = $this->DepartamentoRepository->ValidarDepartamentoEliminar($Id_Departamento);

        if(!empty($Validar)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{

           $Eliminar = $this->DepartamentoRepository->EliminarDepartamento($Id_Departamento);

            return $this->respondWithData(["Eliminar" => $Eliminar]);
        }
        
    }
}

