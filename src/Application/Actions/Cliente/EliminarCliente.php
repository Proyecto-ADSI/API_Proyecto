<?php

declare(strict_types = 1);

namespace App\Application\Actions\Cliente;
use Psr\Http\Message\ResponseInterface as Response;
class EliminarCliente extends ClienteAction
{

    protected function action(): Response
    {
        $Id_Cliente = (int)$this->resolveArg('Id_Cliente_Eliminar');

        $r = $this->ClienteRepository->ValidarEliminarCliente($Id_Cliente);

        //  $this->logger->info("Datos".json_encode($r));

        // Validar si variable tiene algún registro
        if(!empty($r)){

            return $this->respondWithData(["Eliminar" => false]);
        }else{


           $r = $this->ClienteRepository->EliminarCliente($Id_Cliente);



            return $this->respondWithData(["Eliminar" => $r]);
        }





       
       
    }

}