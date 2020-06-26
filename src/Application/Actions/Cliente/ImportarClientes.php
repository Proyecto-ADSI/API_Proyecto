<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use App\Application\Actions\Notificaciones\RegistrarNotificaciones;
use App\Domain\Cliente\Cliente;
use App\Domain\Cliente\ClienteImportado;
use App\Domain\DBL\DBL;
use App\Domain\Notificacion\Notificacion;
use App\Domain\Plan_Corporativo\Plan_Corporativo;
use Psr\Http\Message\ResponseInterface as  Response;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportarClientes extends ClienteAction
{
    private $arrayClientesImportados = [];
    private $arrayCliente = [];

    protected function action(): Response
    {
        // ------------------------------------------  1) Guardar el archivo  --------------------------------------------------------
        $directorio = __DIR__ . '\Archivos';
        $archivosCargados = $this->request->getUploadedFiles();
        $archivo = $archivosCargados['Archivo_Clientes'];
        $rutaArchivo = "";
        if ($archivo->getError() === UPLOAD_ERR_OK) {

            $extension = pathinfo($archivo->getClientFilename(), PATHINFO_EXTENSION);
            $basename = bin2hex(random_bytes(8));
            $filename = sprintf('%s.%0.8s', $basename, $extension);

            $archivo->moveTo($directorio . DIRECTORY_SEPARATOR . $filename);

            $rutaArchivo = $directorio . DIRECTORY_SEPARATOR . $filename;
        } else {

            return $this->respondWithData(["ok" => false]);
        }

        // ---------------------------------------------- 2)  Cargar el archivo y recorrerlo -------------------------------------------

        $documento = IOFactory::load($rutaArchivo);

        # obtener conteo e iterar
        $totalDeHojas = $documento->getSheetCount();

        # Iterar hoja por hoja
        for ($indiceHoja = 0; $indiceHoja < $totalDeHojas; $indiceHoja++) {
            # Obtener hoja en el índice que vaya del ciclo
            $hojaActual = $documento->getSheet($indiceHoja);

            # Calcular el máximo valor de la fila como entero, es decir, el
            # límite de nuestro ciclo
            $numeroMayorDeFila = $hojaActual->getHighestRow(); // Numérico
            $letraMayorDeColumna = $hojaActual->getHighestColumn(); // Letra
            # Convertir la letra al número de columna correspondiente
            $numeroMayorDeColumna = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($letraMayorDeColumna);

            # Iterar filas con ciclo for e índices
            for ($indiceFila = 1; $indiceFila <= $numeroMayorDeFila; $indiceFila++) {
                for ($indiceColumna = 1; $indiceColumna <= $numeroMayorDeColumna; $indiceColumna++) {

                    # Obtener celda por columna y fila
                    $celda = $hojaActual->getCellByColumnAndRow($indiceColumna, $indiceFila);
                    # Y ahora que tenemos una celda trabajamos con ella igual que antes
                    # El valor, así como está en el documento
                    $valorRaw = $celda->getValue();

                    # Formateado por ejemplo como dinero o con decimales
                    $valorFormateado = $celda->getFormattedValue();

                    # Si es una fórmula y necesitamos su valor, llamamos a:
                    $valorCalculado = (string) $celda->getCalculatedValue();
                    # Fila, que comienza en 1, luego 2 y así...
                    $fila = $celda->getRow();
                    # Columna, que es la A, B, C y así...
                    $columna = $celda->getColumn();

                    if ($fila >  1) {

                        array_push($this->arrayCliente, $valorRaw);

                        if ($indiceColumna === $numeroMayorDeColumna) {

                            // Objeto cliente
                            $DatosCliente = array(
                                $this->arrayCliente[0],
                                $this->arrayCliente[1],
                                $this->arrayCliente[2],
                                $this->arrayCliente[3],
                                $this->arrayCliente[4],
                                $this->arrayCliente[5],
                                $this->arrayCliente[6],
                                $this->arrayCliente[7],
                                $this->arrayCliente[8],
                                $this->arrayCliente[9],
                                $this->arrayCliente[10],
                                $this->arrayCliente[11],
                                $this->arrayCliente[12],
                                $this->arrayCliente[13],
                                $this->arrayCliente[14],
                                $this->arrayCliente[15],
                                $this->arrayCliente[16],
                                $this->arrayCliente[17],
                            );



                            // Agregar al array principla del clientes.
                            array_push($this->arrayClientesImportados, $DatosCliente);

                            // borrar los datos que tiene el array cliente.
                            $this->arrayCliente = [];
                        }
                    }
                }
            }
        }

        // ---------------------------------------------- 3) Recorrer los clientes importados  -------------------------------------------

        // Recorrer el array principal de clientes.   
        $arrayClientes = $this->arrayClientesImportados;
        $arrayClientesError = array();
        $Importacion = false;

        foreach ($arrayClientes as $cliente) {

            try {
                $clienteImportado = new ClienteImportado(
                    NULL,
                    (string)  $cliente[0],
                    (string)  $cliente[1],
                    (string)  $cliente[2],
                    (string)  $cliente[3],
                    (string)  $cliente[4],
                    (string)  $cliente[5],
                    (string)  $cliente[6],
                    (string)  $cliente[7],
                    (string)  $cliente[8],
                    (string)  $cliente[9],
                    (string)  $cliente[10],
                    (string)  $cliente[11],
                    (string)  $cliente[12],
                    (string)  $cliente[13],
                    (string)  $cliente[14],
                    (string)  $cliente[15],
                    (string)  $cliente[16],
                    (string)  $cliente[17],
                    NULL
                );
            } catch (\Exception $e) {
                return $this->respondWithData($e);
            }



            // ---------------------  3.1 )  Validar objeto y registrar en la BD  (tablas principales.) -------------------------------------------

            // Validaciones

            // Validar barrio
            $idUbicacion = $this->ClienteRepository->ValidarUbicacionCliente($clienteImportado->__GET("Municipio"), $clienteImportado->__GET("Barrio"));

            $idBarrioVereda = NULL;
            if (!empty($idUbicacion)) {

                $idBarrioVereda = (int) $idUbicacion['Id_Barrios_Veredas'];
            }

            // Validar operador

            $datosOperador = $this->ClienteRepository->ValidarOperadorCliente($clienteImportado->__GET("Operador_Actual"));

            $idOperador = NULL;
            if (!empty($datosOperador)) {

                $idOperador = (int) $datosOperador['Id_Operador'];
            }

            // Plan Corporativo

            if ($clienteImportado->__GET("Tiene_PC") == "SI") {

                $clausulaPermanencia = NULL;
                if ($clienteImportado->__GET("Clausula_Permanencia") == "SI") {
                    $clausulaPermanencia = 1;
                } else if ($clienteImportado->__GET("Clausula_Permanencia") == "NO") {
                    $clausulaPermanencia = 0;
                }

                // Fecha inicio.
                $fechaInicioExcel = (int) $clienteImportado->__GET("Fecha_Inicio");
                $fechaDateInicio = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaInicioExcel);
                $fechaFormateadaInicio = $fechaDateInicio->format('yy-m-d');
                // Fecha fin.
                $fechaFinExcel = (int) $clienteImportado->__GET("Fecha_Fin");
                $fechaDateFin = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaFinExcel);
                $fechaFormateadaFin = $fechaDateFin->format('yy-m-d');

                $objPlanCorporativo = new Plan_Corporativo(
                    NULL,
                    NULL,
                    $fechaFormateadaInicio,
                    $fechaFormateadaFin,
                    $clausulaPermanencia,
                    $clienteImportado->__GET("Descripcion"),
                    NULL
                );

                $r =  $this->Plan_CorporativoRepository->RegistrarPlan_Corporativo($objPlanCorporativo);
            }

            // Cliente
            $objCliente = new Cliente(
                NULL,
                $clienteImportado->__GET("NIT_CDV"),
                $clienteImportado->__GET("Razon_Social"),
                $clienteImportado->__GET("Telefono"),
                $clienteImportado->__GET("Extension"),
                $clienteImportado->__GET("Encargado"),
                $clienteImportado->__GET("Correo"),
                $clienteImportado->__GET("Celular"),
                $clienteImportado->__GET("Direccion"),
                $idBarrioVereda,
                1
            );
            $r =  $this->ClienteRepository->RegistrarCliente($objCliente);
            // Datos Básicos Líneas
            $idCLiente = $this->ClienteRepository->ConsultarUltimoRegistrado();
            $idPlanCorporativo = $this->Plan_CorporativoRepository->ConsultarUltimoRegistrado();
            $dbl = new DBL(
                NULL,
                (int) $idCLiente['Id_Cliente'],
                $idOperador,
                (int) $idPlanCorporativo['Id_Plan_Corporativo'],
                (int) $clienteImportado->__GET("Cantidad_Total_Lineas"),
                $clienteImportado->__GET("Valor_Total_Mensual"),
                NULL,
                NULL,
                NULL
            );
            $r = $this->DBLRepository->RegistrarDBL($dbl);
            // ----------------------------------  4) Registrar en la BD CLientes con conflictos (tabla temporal) -------------------------------------------
            // $this->ClienteRepository->ImportarClientes($clienteImportado);     
            // $arrayarrayClientesImportados = $this->ClienteRepository->ListarClienteImportados();
        }
        // ----------------------------------  5) Eliminar archivo. ------------------------------------------------------------
        unlink($rutaArchivo);
        // ----------------------------------  6) Generar notificación. ------------------------------------------------------------
        // Id_Usuario
        $Id_Usuario = (int) $this->resolveArg("Id_Usuario");
        // Cantidad de empresas
        $Cantidad = count($arrayClientes);
        // Registrar notificación.
        $mensaje = $Cantidad . " nuevas empresas importadas.";
        $notificacion = new Notificacion(
            NULL,
            $Id_Usuario,
            NULL,
            $mensaje,
            2,
            NULL
        );

        $usuarios = array(1, 2);

        $RegistroNotificacion = new RegistrarNotificaciones(
            $this->logger,
            $this->Notificaciones_UsuarioRepository,
            $this->NotificacionRepository
        );

        $r = $RegistroNotificacion->RegistrarNotificacion($notificacion, $usuarios);

        if ($r === true) {
            $Importacion = true;
        }
        // ----------------------------------  7) Retornar respuesta al cliente. ------------------------------------------------------------
        if ($Importacion) {
            if (count($arrayClientesError) == 0) {
                return $this->respondWithData(["Importacion"  => true, "Errores"  => false]);
            } else {
                return $this->respondWithData(["Importacion"  => true, "Errores"  => true]);
            }
        } else {
            return $this->respondWithData(["Importacion"  => false]);
        }
    }
}
