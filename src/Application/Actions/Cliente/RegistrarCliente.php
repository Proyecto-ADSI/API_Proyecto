<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Domain\Cliente\Cliente;
use App\Domain\DBL\DBL;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Domain\Linea\Linea;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Domain\Notificacion\Notificacion;
use App\Domain\Notificaciones_Usuario\Notificaciones_Usuario;

use App\Application\Actions\Notificaciones\RegistrarNotificaciones;

use Psr\Http\Message\ResponseInterface as Response;

class RegistrarCliente extends ClienteAction
{

    protected function action(): Response
    {
        $campos = $this->getFormData();

        $respuesta = $this->RegistrarClientes($campos);
        
        // Respuesta es TRUE || FALSE
        return $this->respondWithData(["ok" => $respuesta]);
      
    }

    public function RegistrarClientes($campos){

        $validacion = NULL;

        // Registrar Cliente
        $Cliente = new Cliente(
            NULL,
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Encargado,
            $campos->Ext_Tel_Contacto,
            $campos->Direccion,
            $campos->Barrio_Vereda,
            NULL
        );  

        $validacion = $this->ClienteRepository->RegistrarCliente($Cliente);

        $infoCliente = $this->ClienteRepository->ConsultarUltimoRegistrado();

        $DBL = new DBL(
            NULL,
            (int) $infoCliente['Id_Cliente'],
            $campos->Id_Operador,
            NULL,
            $campos->Cantidad_Lineas,
            $campos->Valor_Mensual,
            $campos->Id_Calificacion_Operador,
            $campos->Razones,
            NULL
        );

        // Validar si se registra el plan corporativo

        if ($campos->Validacion_PLan_C) {

            // Plan Corporativo sin documentos
            $Plan_Corporativo = new Plan_Corporativo(
                NULL,
                NULL,
                $campos->Fecha_Inicio,
                $campos->Fecha_Fin,
                $campos->Clausula,
                $campos->Descripcion,
                NULL
            );

            if ($campos->Validacion_Doc_S) {

                // Registrar documentos
                $Doc_Soporte = new Doc_Soporte(
                    Null,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );

                $this->Doc_SoporteRepository->RegistrarDocSoporte($Doc_Soporte);

                $InfoIdDoc = $this->Doc_SoporteRepository->ConsultarUltimoRegistrado();
                $Id_Documentos = (int) $InfoIdDoc['Id_Documentos'];

                // Registrar plan corporativo
                $Plan_Corporativo->__set("Id_Documentos",$Id_Documentos);
                $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);

            } else {
                
                $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            }

            // Datos básicos líneas con plan corporativo
            $InfoIdPlan = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();
            
            $Id_Plan_Corporativo = (int) $InfoIdPlan['Id_Plan_Corporativo'];
            $DBL->__set("Id_Plan_Corporativo",$Id_Plan_Corporativo);
            
            $r = $this->DBLRepository->RegistrarDBL($DBL);
            
           $this->logger->info(" Datos: ".json_encode($r));
           
        } else {

            // Datos básicos líneas sin plan corporativo
            $this->DBLRepository->RegistrarDBL($DBL);
        }
        
        //Id_Datos_Basicos_Lineas
        $InfoIdDBL = $this->DBLRepository->ConsultarUltimoRegistrado();
        $Id_DBL = (int) $InfoIdDBL['Id_DBL'];
        $arrayLineas = $campos->DetalleLineas;
        
        if(!empty($arrayLineas)){
            foreach($arrayLineas as $lineaItem){
                
                $linea = new Linea(
                    NULL,
                    NULL,
                    $lineaItem->minutos,
                    $lineaItem->navegacion,
                    $lineaItem->mensajes,
                    $lineaItem->redes,
                    $lineaItem->llamadas,
                    $lineaItem->roaming,
                    $lineaItem->cargo,
                    $lineaItem->grupo
                );

                if(!empty($lineaItem->numero)){
                    $linea->__set("Linea",$lineaItem->numero);
                }
                
                $this->LineaRepository->RegistrarLinea($linea);
    
                $infoIdLinea = $this->LineaRepository->ConsultarUltimaLinea();
                $Id_Linea = (int)$infoIdLinea['Id_Linea'];
                $validacion = $this->LineaRepository->RegistrarDetalleLinea($Id_Linea, $Id_DBL );
            }
        }

        // Registrar notificación.
        $mensaje = "Nueva empresa registrada.";
        $notificacion = new Notificacion(
            NULL,
            $campos->Id_Usuario,
            NULL,
            $mensaje,
            2,
            (int) $infoCliente['Id_Cliente']
        );
        
        $usuarios = array(1,2);

        $RegistroNotificacion = new RegistrarNotificaciones(
            $this->logger,
            $this->Notificaciones_UsuarioRepository,
            $this->NotificacionRepository
        );

        $RegistroNotificacion->RegistrarNotificacion($notificacion,$usuarios);

        return true;
    }
}
