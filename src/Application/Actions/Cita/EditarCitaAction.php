<?php

declare(strict_types=1);

namespace App\Application\Actions\Cita;

use App\Application\Actions\Cita\CitaAction;
use Psr\Http\Message\ResponseInterface as Response;

class EditarCitaAction extends CitaAction
{
    protected function action(): Response
    {
         $campos = $this->getFormData();

       
         $Id_Cita = (int) $campos->Id_Cita;
         $Encargado = $campos->Encargado;
         $Ext_Tel = $campos->Ext_Tel;
         $Representante = $campos->Representante;
         $Fecha = $campos->Fecha_Cita;
         $Direccion = $campos->Direccion;
         $Id_Barrios_Vereda = $campos->Id_Barrios_Vereda;
         $Lugar_Referencia = $campos->Lugar_Referencia;
         $Id_Operador = $campos->Id_Operador;


         $Editar = $this->CitaRepository->EditarCita($Id_Cita,$Encargado,$Ext_Tel,$Representante,$Fecha,$Direccion,$Id_Barrios_Vereda,$Lugar_Referencia,$Id_Operador);

        return $this->respondWithData($Editar);

    }
}