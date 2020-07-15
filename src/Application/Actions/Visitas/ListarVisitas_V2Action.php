<?php

declare(strict_types=1);

  namespace App\Application\Actions\Visitas;

  use Psr\Http\Message\ResponseInterface as Response;

  class ListarVisitas_V2Action extends VisitasAction
  {
   protected function action(): Response
   {
       $Visitas_V2 = $this->VisitasRepository->ListarVisitas_V2();

       return $this->respondWithData($Visitas_V2);
   }
   
  }
