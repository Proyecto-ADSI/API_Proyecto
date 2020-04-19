<?php

declare(strict_types = 1);

namespace App\Application\Actions\Cliente;
use Psr\Http\Message\ResponseInterface as Response;
class EliminarCliente extends ClienteAction
{
    protected function action(): Response
    {
        $Id_Cliente = (int)$this->resolveArg('Id_Cliente_Eliminar');

        $validacionCliente = $this->ClienteRepository->ValidarEliminarCliente($Id_Cliente);

        // Validar si variable tiene algún registro
        // Devuelve true si $r tiene algún registro
        if(!empty($validacionCliente)){
            return $this->respondWithData(["Eliminar" => false]);
        }else{

            $infoDBL = $this->DBLRepository->ListarDBL($Id_Cliente,1);
        
            $Id_DBL = (int)$infoDBL['Id_DBL'];
            $Id_Plan_C = (int)$infoDBL['Id_Plan_Corporativo'];
            
            $infoPlan = $this->Plan_CorporativoRepository->ListarPlan_Corporativo($Id_Plan_C);
            $Id_Documentos = (int)$infoPlan['Id_Documentos'];
           
            $infoDetalleLinea = $this->DBLRepository->ConsultarDetalleLineas($Id_DBL);

            $this->logger->info("infoDetalleLinea ".json_encode($infoDetalleLinea));

            if(!empty($infoDetalleLinea)){
               
                $this->DBLRepository->EliminarDetalleLineas($Id_DBL);

                foreach($infoDetalleLinea as $linea){
                    
                    $Id_Linea = (int) $linea['Id_Linea'];
                   
                    $this->LineaRepository->EliminarLinea($Id_Linea);
                }
            }

            $this->DBLRepository->ELiminarDBL($Id_DBL);
            
            if($Id_Plan_C > 0){
                $this->Plan_CorporativoRepository->EliminarPlan_Corporativo($Id_Plan_C);
            }
            if($Id_Documentos > 0){
                $this->Doc_SoporteRepository->EliminarDocSoporte($Id_Documentos);
            }
           
            $r = $this->ClienteRepository->EliminarCliente($Id_Cliente);

            return $this->respondWithData(["Eliminar" => $r]);
        }       
    }
}