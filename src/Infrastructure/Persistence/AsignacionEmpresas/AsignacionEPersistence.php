<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\AsignacionEmpresas;

use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Infrastructure\DataBase;
use PDO;

class AsignacionEPersistence implements AsignacionERepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }


    public function ValidarEmpresasAsignadas(int $Id_Usuario)
    {
        $sql = "SELECT Id_Usuario, COUNT(Id_Usuario) Cantidad  FROM empresas_asignadas WHERE Id_Usuario = ? GROUP BY Id_Usuario ORDER BY 1";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function ValidarEmpresaAsignadaContact(int $Id_Usuario, int $Id_Cliente)
    {
        $sql = "SELECT COUNT(Id_Cliente) Asignada  FROM empresas_asignadas WHERE Id_Usuario = ? AND Id_Cliente = ? ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Id_Cliente);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function ObtenerCantidadEmpresasContact()
    {
        $sql = "SELECT Id_Usuario, COUNT(Id_Usuario) Cantidad  FROM empresas_asignadas GROUP BY Id_Usuario ORDER BY 1";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function ObtenerEmpresasContact(int $Id_Usuario, int $Estado)
    {
        $sql = "SELECT Id_Usuario, Id_Cliente FROM empresas_asignadas WHERE Id_Usuario = ? AND  Estado_Asignacion = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Estado);
            $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function EliminarTodasEmpresasAsignadas(int $Id_Usuario)
    {

        $sql = "DELETE FROM empresas_asignadas WHERE Id_Usuario = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarEmpresasAsignadasValidacion(int $Id_Usuario, int $Id_Cliente)
    {
        $sql = "DELETE FROM empresas_asignadas WHERE Id_Usuario = ? AND Id_Cliente != ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Id_Cliente);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function EliminarEmpresaAsignada(int $Id_Usuario, int $Id_Cliente)
    {
        $sql = "DELETE FROM empresas_asignadas WHERE Id_Usuario = ? AND Id_Cliente = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Id_Cliente);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function SeleccionarEmpresasDisponibles(int $Cantidad)
    {
        // Validacion_Llamda
        // 1 -> Ya se llamó
        // 2 -> No se ha llamado
        $sql = "SELECT d.Id_Cliente, d.Fecha_Control, 
        CASE WHEN ISNULL(l.Id_Llamada) = 0 THEN 1 ELSE 0 END AS Validacion_Llamada 
        FROM directorio d LEFT JOIN llamadas l ON(d.Id_Cliente = l.Id_Cliente) 
        WHERE d.Estado_Cliente = 1 ORDER by 3,2 LIMIT " . $Cantidad;
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function AsignarEmpresasContact(int $Id_Usuario, int $Id_Cliente)
    {
        $sql = "INSERT INTO empresas_asignadas (Id_Usuario, Id_Cliente,Estado_Asignacion)
        VALUES (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->bindValue(2, $Id_Cliente);
            $stm->bindValue(3, 1);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function SeleccionarEmpresaAsignada(int $Id_Usuario)
    {
        $sql = "SELECT Id_Cliente FROM empresas_asignadas WHERE Id_Usuario = ? LIMIT 1";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Usuario);
            $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function CambiarEstadoAEnLlamada(int $Id_Cliente)
    {
        $sql = "UPDATE empresas_asignadas SET Estado_Asignacion = ? WHERE Id_Cliente = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, 2);
            $stm->bindValue(2, $Id_Cliente);
            $res = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return $res;
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    public function ObtenerCantidadEmpresasRe_Asignables()
    {
        $sql = "SELECT COUNT(Id_Cliente) Cantidad FROM directorio 
        WHERE Estado_Cliente = 1 OR Id_Cliente IN 
        (SELECT Id_Cliente FROM empresas_asignadas WHERE Estado_Asignacion != 2)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = $stm->errorInfo();
                return $error;
            }
        } catch (\Exception $e) {
            return null;
        }
    }
}
