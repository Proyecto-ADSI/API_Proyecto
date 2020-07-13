<?php

declare(strict_types=1);

namespace App\Application\Actions\Configuracion;

use Psr\Http\Message\ResponseInterface as Response;

class MetodosSistema extends ConfiguracionAction
{
    protected function action(): Response
    {
        return $this->respondWithData(true);
    }

    public function AsignarEmpresas(int $Id_Usuario)
    {
        $config = $this->ConfiguracionRepository->ListarConfiguracion();
        $EmpresasXContact = (int) $config['EmpresasXContact'];
        if ($EmpresasXContact > 0) {
            // Asignar lote empresas
            $lote = $this->AsignacionERepository->SeleccionarEmpresasDisponibles($EmpresasXContact);
            foreach ($lote as $empesa) {
                $Id_Cliente = (int) $empesa['Id_Cliente'];
                // Asignar empresa
                $res = $this->AsignacionERepository->AsignarEmpresasContact($Id_Usuario, $Id_Cliente);
                // Inhabilitar Empresa
                $res = $this->ClienteRepository->CambiarEstadoCliente($Id_Cliente, 0);
            }
            $res = $this->CrearRespuesta(true, NULL);
            return $res;
        } else {
            $res = $this->CrearRespuesta(false, "Cantidad permitida de asignación no es válida, registre empresas y usuarios con rol contact center.");
            return $res;
        }
    }

    public function PrecargarEmpresa(int $Id_Usuario)
    {
        $infoId = $this->AsignacionERepository->SeleccionarEmpresaAsignada($Id_Usuario);
        $Id_Cliente = (int) $infoId['Id_Cliente'];
        $this->AsignacionERepository->CambiarEstadoAEnLlamada($Id_Cliente);
        $infoEmpresa = $this->ClienteRepository->ObtenerCliente($Id_Cliente);
        return $infoEmpresa;
    }

    public function CrearEventoHabilitar(int $Id_Cliente)
    {
        $config = $this->ConfiguracionRepository->ListarConfiguracion();
        $diasInhabilitacion = (int) $config['Dias_Inhabilitacion'];
        date_default_timezone_set("America/Bogota");
        $fecha = time();
        $fechaActual = date("Y-m-d H:i:s", $fecha);
        $fechaNueva = strtotime("+" . $diasInhabilitacion . "day", strtotime($fechaActual));
        $Fecha_Control =  date("Y-m-d H:i:s", $fechaNueva);

        $res = $this->ConfiguracionRepository->CrearEventoHabilitar($Id_Cliente, $Fecha_Control);
        return $res;
    }

    public function ModificarEXC()
    {
        // Validar cantidad contacts center
        // 3 Contact center 
        // 1 Habilitado
        $res = $this->UsuarioRepository->ObtenerCantidadUsuarios(3, 1);
        $cantidadC = (int) $res['Cantidad'];

        if ($cantidadC > 0) {
            // Validar cantidad empresas habilitadas o asignadas sin llamar.
            $res = $this->AsignacionERepository->ObtenerCantidadEmpresasRe_Asignables();
            $cantidadE = (int) $res['Cantidad'];

            if ($cantidadE > 0) {
                // Calcular Cantidad empresas x contact
                $EmpresasXContact = floor($cantidadE / $cantidadC);
                if ($EmpresasXContact > 0) {
                    $res = $this->ConfiguracionRepository->ModificarCampoConfiguracion("EmpresasXContact", $EmpresasXContact);
                    return $res;
                    // $res = $this->CrearRespuesta($res, NULL);

                } else {
                    $this->ConfiguracionRepository->ModificarCampoConfiguracion("EmpresasXContact", 0);
                    $res = $this->CrearRespuesta(false, "No hay suficientes empresas para asignar");
                    return $res;
                }
            } else {
                $this->ConfiguracionRepository->ModificarCampoConfiguracion("EmpresasXContact", 0);
                $res = $this->CrearRespuesta(false, "No hay empresas registradas.");
                return $res;
            }
        } else {
            $this->ConfiguracionRepository->ModificarCampoConfiguracion("EmpresasXContact", 0);
            $res = $this->CrearRespuesta(false, "No hay contact center registrados.");
            return $res;
        }
    }

    public function ValidarEmpresasAsignadas()
    {
        $Reasignar = false;
        $UsuariosReasignar = [];
        $config = $this->ConfiguracionRepository->ListarConfiguracion();
        $EmpresasXContact = (int) $config['EmpresasXContact'];

        // Cantidad de empresas que tiene asignadas cada usuario
        $infoEmpresas = $this->AsignacionERepository->ObtenerCantidadEmpresasContact();
        foreach ($infoEmpresas as $item) {
            // Validar si el lote que tiene el usuario es mayor a la cantidad permitida.
            $cantidadEAsignadas = (int) $item['Cantidad'];
            $Id_Usuario = (int) $item['Id_Usuario'];
            if ($cantidadEAsignadas > $EmpresasXContact) {
                $Reasignar = true;
                array_push($UsuariosReasignar, $Id_Usuario);
                // Habilitar empresas
                $empresasContact = $this->AsignacionERepository->ObtenerEmpresasContact($Id_Usuario, 1);
                if (!empty($empresasContact)) {
                    foreach ($empresasContact as $empresa) {
                        $Id_Cliente = (int) $empresa['Id_Cliente'];
                        $this->ClienteRepository->CambiarEstadoCliente($Id_Cliente, 1);
                        // // Eliminar evento de la BD
                        // $this->ConfiguracionRepository->EliminarEventoHabilitar($Id_Cliente);
                    }
                }
                // Eliminar empresas solo dejando la que se encuentre en llamada (2), si la hay.
                $empresaEnLlamada = $this->AsignacionERepository->ObtenerEmpresasContact($Id_Usuario, 2);
                if (!empty($empresaEnLlamada)) {
                    $Id_Cliente_Llamada = (int) $empresaEnLlamada[0]['Id_Cliente'];
                    $this->AsignacionERepository->EliminarEmpresasAsignadasValidacion($Id_Usuario, $Id_Cliente_Llamada);
                } else {
                    $this->AsignacionERepository->EliminarTodasEmpresasAsignadas($Id_Usuario);
                }
            }
        }
        if ($Reasignar) {
            // Recalcular Empresas por contact
            $this->ModificarEXC();
            // Reasignar empresas
            $this->ReasignarEmpresas($UsuariosReasignar);
        }
    }

    public function ReasignarEmpresas(array $UsuariosReasignar)
    {
        $config = $this->ConfiguracionRepository->ListarConfiguracion();
        $EmpresasXContact = (int) $config['EmpresasXContact'];

        foreach ($UsuariosReasignar as $Id_Usuario) {
            $cantidadAsignar = $EmpresasXContact;
            // Validar si tiene empresa en llamada asigandas
            $empresaEnLlamada = $this->AsignacionERepository->ObtenerEmpresasContact($Id_Usuario, 2);
            if (!empty($empresaEnLlamada)) {
                $cantidadAsignar = $EmpresasXContact - 1;
            }
            $lote = $this->AsignacionERepository->SeleccionarEmpresasDisponibles($cantidadAsignar);
            foreach ($lote as $empesa) {
                $Id_Cliente = (int) $empesa['Id_Cliente'];
                // Asignar empresa
                $this->AsignacionERepository->AsignarEmpresasContact($Id_Usuario, $Id_Cliente);
                // Inhabilitar Empresa
                $this->ClienteRepository->CambiarEstadoCliente($Id_Cliente, 0);
            }
        }
    }


    private function CrearRespuesta(bool $ok, ?string $error)
    {
        $respuesta = [
            "ok" => $ok,
            "Error" => $error,
        ];
        return $respuesta;
    }
}
