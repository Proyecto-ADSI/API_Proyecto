<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Configuracion;

use App\Domain\Configuracion\ConfiguracionRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class ConfiguracionPersistence implements ConfiguracionRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function ListarConfiguracion()
    {
        $sql = "SELECT * FROM configuracion_sistema";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ModificarCampoConfiguracion($campo, $valor)
    {
        $sql = "UPDATE configuracion_sistema SET " . $campo . " = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $valor);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function CrearEventoHabilitar(int $Id_Cliente, string $Fecha_Control)
    {
        // Set fecha control
        $sql = "UPDATE directorio SET Fecha_Control = ? WHERE Id_Cliente = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Fecha_Control);
            $stm->bindValue(2, $Id_Cliente);
            $res = $stm->execute();
            if ($res) {
                // Crear evento en la BD.
                $evento = "CREATE EVENT habilitar_cliente_" . $Id_Cliente . "
                ON SCHEDULE AT :Fecha_Control
                DO UPDATE directorio SET Estado_Cliente = :Estado_Cliente WHERE Id_Cliente = :Id_Cliente";
                try {
                    $stm = $this->db->prepare($evento);
                    $stm->bindParam(":Fecha_Control", $Fecha_Control);
                    $stm->bindValue(":Estado_Cliente", 1);
                    $stm->bindParam(":Id_Cliente", $Id_Cliente);

                    $res = $stm->execute();

                    $error = $stm->errorCode();
                    if ($error === '00000') {
                        return $res;
                    } else {
                        return $stm->errorInfo();
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            } else {
                return $stm->errorInfo();
            }
            return $res;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // public function EliminarEventoHabilitar(int $Id_Cliente)
    // {
    //     $sql = "DROP EVENT habilitar_cliente_" . $Id_Cliente;
    //     try {
    //         $stm = $this->db->prepare($sql);
    //         $res = $stm->execute();
    //         $error = $stm->errorCode();
    //         if ($error === '00000') {
    //             return $res;
    //         } else {
    //             $error = $stm->errorInfo();
    //             return $error;
    //         }
    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }
}
