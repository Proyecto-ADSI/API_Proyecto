<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerCliente extends ClienteAction
{
    protected function action(): Response
    {

        $Id_Cliente = (int) $this->resolveArg("Id_Cliente");

        $Cliente = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
        $DBL = $this->DBLRepository->ListarDBL($Id_Cliente);

        $Id_Plan_Corporativo = (int) $DBL["Id_Plan_Corporativo"];
        $Plan_Corporativo = $this->Plan_CorporativoRepository->ListarPlan_Corporativo($Id_Plan_Corporativo);

        $Id_Documentos = (int) $Plan_Corporativo["Id_Documentos"];
        $Documentos_Soporte = $this->Doc_SoporteRepository->ListarDocSoporte($Id_Documentos);


        
        

        return  $this->respondWithData($Plan_Corporativo);
    }
}