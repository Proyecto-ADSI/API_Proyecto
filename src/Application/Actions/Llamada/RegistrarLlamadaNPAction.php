<?php

declare(strict_types=1);

namespace App\Application\Actions\Llamada;

use App\Application\Actions\Cliente\RegistrarCliente;
use App\Domain\Llamada\Llamada;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarLlamadaNPAction extends LlamadaAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $this->logger->info("Datos: " . json_encode($campos));

        // Registrar Cliente
        $objCliente = new RegistrarCliente(
            $this->logger,
            $this->ClienteRepository,
            $this->DBLRepository,
            $this->Plan_CorporativoRepository,
            $this->Doc_SoporteRepository,
            $this->BarriosVeredasRepository,
            $this->SubTipoRepository,
            $this->MunicipioRepository,
            $this->DepartamentoRepository,
            $this->PaisRepository,
            $this->LineaRepository
        );

        $objCliente->RegistrarClientes($campos);
        $infoCliente = $this->ClienteRepository->ConsultarUltimoRegistrado();
        $Id_Cliente =(int) $infoCliente['Id_Cliente'];

        $llamada = new Llamada(
            NULL,
            $campos->Id_Usuario,
            $Id_Cliente,
            $campos->Persona_Responde,
            NULL,
            $campos->Info_Habeas_Data,
            $campos->Observacion,
            $campos->Id_Estado_Llamada
        );
        
        $respuesta = $this->LlamadaRepository->RegistrarLlamada($llamada);
        
        return $this->respondWithData(["ok"=> $respuesta]);
        
    }
}

