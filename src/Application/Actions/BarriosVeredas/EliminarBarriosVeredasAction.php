<?php

declare(strict_types=1);

namespace App\Application\Actions\BarriosVeredas;

// use App\Domain\Documento\Documento;
use Psr\Http\Message\ResponseInterface as Response;

class EliminarBarriosVeredasAction extends BarriosVeredasAction
{
    protected function action(): Response
    {
        $Id_Barrios_Veredas = (int)$this->resolveArg("Id_Barrios_Veredas");
        $Eliminar = $this->BarriosVeredasRepository->EliminarBarriosVeredas($Id_Barrios_Veredas);

        $Validar = $this->BarriosVeredasRepository->ValidarBarriosVeredas($Id_Barrios_Veredas);

        return $this->respondWithData(["Eliminar"=> $Validar]);

        // if(!empty($Validar)){

        //     return $this->respondWithData(["Eliminar" => false]);
        // }else{

        //    $Eliminar = $this->BarriosVeredasRepository->EliminarBarriosVeredas($Id_Barrios_Veredas);

        //     return $this->respondWithData(["Eliminar" => $Eliminar]);
        // }
        
    }
}

