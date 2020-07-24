<?php

declare(strict_types=1);

namespace App\Application\Actions\Oferta;

use Psr\Http\Message\ResponseInterface as Response;

class CambiarEstadoOferta extends OfertaAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $Id_Usuario = (int) $campos->Id_Usuario;
        $Id_Oferta = (int) $campos->Id_Oferta;
        $Id_Estado = (int) $campos->Id_Estado;

        $res = $this->OfertaRepository->CambiarEstadoOferta($Id_Oferta,$Id_Estado);

        if($res){
            $Mensaje = "";
            switch($Id_Estado){
                case 2:
                    $Mensaje = "Se inició negociación de oferta con el cliente";
                break; 
                case 3:
                    $Mensaje = "El cliente aceptó la oferta";
                break; 
                case 4 :
                    $Mensaje = "La oferta quedó pendiente de verificación";
                break; 
                case 5:
                    $Mensaje = "La oferta quedó pendiente de activación";
                break; 
                case 6:
                    $Mensaje = "La oferta se activó";
                break; 
                case 7:
                    $Mensaje = "El cliente rechazó la oferta";
                break; 
                case 8:
                    $Mensaje = "El cliente no contestó la oferta";
                break; 
                case 9:
                    $Mensaje = "La oferta se inválidó./n" . $campos->Mensaje;
                break; 
            }

            $this->OfertaRepository->RegistrarAccionOferta($Id_Usuario,$Id_Oferta,$Id_Estado,$Mensaje);
        }

        return $this->respondWithData(["ok" => $res]);

    }
}

