<?php

declare(strict_types=1);

namespace App\Application\Actions\Visitas;

use Psr\Http\Message\ResponseInterface as Response;

class ObtenerCliente_VisitasAction extends VisitasAction
{
  protected function action(): Response
  {
    $parametro = $this->request->getQueryParams();

    $Cliente = $this->VisitasRepository->ObtenerCliente_Visitas($parametro['NIT']);

    if (!empty($Cliente)) {

      $EstadoDBL = $Cliente['Estado_DBL'];

      $IdDBL =  (int)$Cliente['Id_DBL'];

      if($Cliente['Id_Estado_Visita'] !== "1"){


        return $this->respondWithData(["EstadoVisita" => false, "Porque" => "La visita ya se realizo"]);

      }
       else{ 

      if ($EstadoDBL == 'Captado') {

        $DBL = $this->DBLRepository->ObtenerDBLVI($IdDBL);

        return $this->respondWithData(["ok" => true, "DBL" => $DBL]);

      } else if ($EstadoDBL == 'Actual') {

        $DBL = $this->DBLRepository->ObtenerDBLVI($IdDBL);

        return $this->respondWithData(["ok" => true,"Cliente" =>$Cliente ,"DBL" => $DBL]);
      }
      else if ($EstadoDBL == 'Sin validar'){

        return $this->respondWithData(["EstadoDBL" => false, "Mensaje"=>"Se le presento recientemente una oferta y se cambio de DBL esta empresa"]);
        
      }
    }
  }
  else {
    return $this->respondWithData(["ok" => false]);
  }
}
}
