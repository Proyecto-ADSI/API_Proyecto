<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Application\Actions\Configuracion\MetodosSistema;
use App\Domain\Cliente\Cliente;
use App\Domain\DBL\DBL;
use App\Domain\Doc_Soporte\Doc_Soporte;
use App\Domain\Linea\Linea;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use App\Domain\Notificacion\Notificacion;
use App\Domain\Notificaciones_Usuario\Notificaciones_Usuario;

use App\Application\Actions\Notificaciones\RegistrarNotificaciones;
use App\Domain\Lineas_Fijas\Lineas_Fijas;
use Psr\Http\Message\ResponseInterface as Response;

class RegistrarCliente extends ClienteAction
{

    protected function action(): Response
    {
        $campos = $this->getFormData();
        $res = $this->RegistrarClientes($campos);
        if (!is_numeric($res)) {
            return $this->respondWithData(["ok" => false, "error" => $res]);
        } else {
            // Validar si se registra DBL
            if ($campos->Validacion_DBL) {
                $Id_Cliente = $res;
                $this->RegistrarDBL($campos, $Id_Cliente);
            }

            // Actualizar Empresas X Contact en BD
            $metodos = new MetodosSistema(
                $this->logger,
                $this->ConfiguracionRepository,
                $this->UsuarioRepository,
                $this->ClienteRepository,
                $this->AsignacionERepository,
            );
            $metodos->ModificarEXC();
            $metodos->ValidarEmpresasAsignadas();

            return $this->respondWithData(["ok" => true]);
        }
    }
    
    public function RegistrarClientes($campos)
    {
        // Registrar Cliente
        $Cliente = new Cliente(
            NULL,
            $campos->NIT_CDV,
            $campos->Razon_Social,
            $campos->Telefono,
            $campos->Extension,
            $campos->Encargado,
            $campos->Correo,
            $campos->Celular,
            $campos->Direccion,
            $campos->Barrio_Vereda,
            $campos->Estado_Cliente,
        );

        $Id_Cliente = $this->ClienteRepository->RegistrarCliente($Cliente);

        // Registrar notificación.
        $mensaje = "Nueva empresa registrada.";
        $notificacion = new Notificacion(
            NULL,
            $campos->Id_Usuario,
            NULL,
            $mensaje,
            2,
            $Id_Cliente
        );

        $usuarios = array(1, 2);

        $RegistroNotificacion = new RegistrarNotificaciones(
            $this->logger,
            $this->Notificaciones_UsuarioRepository,
            $this->NotificacionRepository
        );

        $RegistroNotificacion->RegistrarNotificacion($notificacion, $usuarios);

        return $Id_Cliente;
    }

    public function RegistrarDBL($campos, int $Id_Cliente)
    {
        $DBL = new DBL(
            NULL,
            $Id_Cliente,
            $campos->Id_Operador,
            NULL,
            $campos->Cantidad_Lineas,
            $campos->Valor_Mensual,
            $campos->Id_Calificacion_Operador,
            $campos->Razones,
            $campos->Estado_DBL
        );
        $Id_DBL = null;
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
            $Id_Plan_Corporativo = null;
            if ($campos->Validacion_Doc_S) {

                // Registrar documentos
                $Doc_Soporte = new Doc_Soporte(
                    Null,
                    $campos->Camara_Comercio,
                    $campos->Cedula_RL,
                    $campos->Soporte_Ingresos,
                    $campos->Detalles_Plan_Corporativo
                );

                $Id_Documentos = $this->Doc_SoporteRepository->RegistrarDocSoporte($Doc_Soporte);
                // Registrar plan corporativo
                $Plan_Corporativo->__set("Id_Documentos", $Id_Documentos);
                $Id_Plan_Corporativo = $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            } else {
                $Id_Plan_Corporativo = $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($Plan_Corporativo);
            }

            // Datos básicos líneas con plan corporativo
            $DBL->__set("Id_Plan_Corporativo", $Id_Plan_Corporativo);
            $Id_DBL = $this->DBLRepository->RegistrarDBL($DBL);
        } else {
            // Datos básicos líneas sin plan corporativo
            $Id_DBL = $this->DBLRepository->RegistrarDBL($DBL);
        }

        $arrayLineas = $campos->ServiciosMoviles;
        $serviciosFijos = $campos->ServiciosFijos;
        // Registrar servicios fijos
        if (isset($serviciosFijos)) {

            $lineasFijas = new Lineas_Fijas(
                NULL,
                $serviciosFijos->pagina,
                $serviciosFijos->correo,
                $serviciosFijos->ip,
                $serviciosFijos->dominio,
                $serviciosFijos->telefonia,
                $serviciosFijos->television
            );

            $IdLineaFija = $this->Lineas_FijasRepository->RegistrarLineas_Fijas($lineasFijas);
            $this->Lineas_FijasRepository->RegistrarDetalleLineas_Fijas($IdLineaFija, $Id_DBL);
        }
        // Registrar servicios móviles.
        if (!empty($arrayLineas)) {
            foreach ($arrayLineas as $lineaItem) {
                $linea = new Linea(
                    NULL,
                    NULL,
                    $lineaItem->minutos,
                    $lineaItem->navegacion,
                    $lineaItem->mensajes,
                    $lineaItem->serviciosIlimitados,
                    $lineaItem->minutosLDI,
                    $lineaItem->cantidadLDI,
                    $lineaItem->serviciosAdicionales,
                    $lineaItem->cargoBasicoMensual,
                    $lineaItem->grupo
                );

                if (!empty($lineaItem->numero)) {
                    $linea->__set("Linea", $lineaItem->numero);
                }
                $Id_Linea = $this->LineaRepository->RegistrarLinea($linea);
                $this->LineaRepository->RegistrarDetalleLinea($Id_Linea, $Id_DBL);
            }
        }
    }
}
