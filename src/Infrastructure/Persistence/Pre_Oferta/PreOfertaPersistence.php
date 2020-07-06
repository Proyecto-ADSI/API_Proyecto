<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Pre_Oferta;

use App\Domain\Pre_Oferta\PreOferta;
use App\Domain\Pre_Oferta\PreOferta_P;
use App\Domain\Pre_Oferta\PreOfertaRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class PreOfertaPersistence implements PreOfertaRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarPreOferta(PreOferta $PreOferta)
    {
        $sql = "INSERT INTO pre_ofertas (Id_AT, Id_Visita,Id_Usuario,Id_Estado_PO,Id_Operador,Nombre_Cliente,Mensaje_Superior,Tipo_Pre_Oferta)
        VALUES (?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $PreOferta->__GET("Id_AT"));
            $stm->bindValue(2, $PreOferta->__GET("Id_Visita"));
            $stm->bindValue(3, $PreOferta->__GET("Id_Usuario"));
            $stm->bindValue(4, $PreOferta->__GET("Id_Estado_PO"));
            $stm->bindValue(5, $PreOferta->__GET("Id_Operador"));
            $stm->bindValue(6, $PreOferta->__GET("Nombre_Cliente"));
            $stm->bindValue(7, $PreOferta->__GET("Mensaje_Superior"));
            $stm->bindValue(8, $PreOferta->__GET("Tipo_Pre_Oferta"));

            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ListarPreOferta()
    {
        $sql = "SELECT b.Id_Barrios_Veredas, b.Codigo , b.Nombre_Barrio_Vereda, b.Estado,m.Id_Municipio, m.Nombre_Municipio
        AS Municipio, s.Id_SubTipo_Barrio_Vereda, s.SubTipo FROM barrios_veredas b
        INNER JOIN municipios m ON (b.Id_Municipio = m.Id_Municipio)                                         
        INNER JOIN subtipo_barrio_vereda s ON (b.Id_SubTipo_Barrio_Vereda = s.Id_SubTipo_Barrio_Vereda)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->execute();

            return $stm->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function ConsultarUltimoRegistrado()
    {
        $sql = "SELECT Id_Pre_Oferta FROM pre_ofertas ORDER BY 1 DESC LIMIT 1";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarPropuestas(int $Cantidad_Lineas, int $Id_Linea_Movil)
    {
        $sql = "INSERT INTO propuestas (Cantidad_Lineas, Id_Linea_Movil) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Cantidad_Lineas);
            $stm->bindValue(2, $Id_Linea_Movil);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ConsultarUltimaPropuestaRegistrada()
    {
        $sql = "SELECT Id_Propuesta FROM propuestas ORDER BY 1 DESC LIMIT 1";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function RegistrarPreOfertaEstandar(int $Id_Pre_Oferta, int $Id_Propuesta)
    {
        $sql = "INSERT INTO pre_oferta_estandar (Id_Pre_Oferta, Id_Propuesta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_Pre_Oferta);
            $stm->bindValue(2, $Id_Propuesta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarPreOfertaPersonalizada(PreOferta_P $Pre_Oferta_P)
    {
        $sql = "INSERT INTO pre_oferta_personalizada (
            Id_Pre_Oferta, 
            Id_Corporativo_Anterior, 
            Id_Corporativo_Actual, 
            Basico_Neto_Operador1, 
            Basico_Neto_Operador2,
            Valor_Neto_Operador1, 
            Valor_Bruto_Operador2, 
            Bono_Activacion, 
            Valor_Neto_Operador2, 
            Total_Ahorro, 
            Reduccion_Anual,
            Valor_Mes_Promedio,
            Ahorro_Mensual_Promedio
            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Pre_Oferta_P->__get("Id_Pre_Oferta"));
            $stm->bindValue(2, $Pre_Oferta_P->__get("Id_Corporativo_Anterior"));
            $stm->bindValue(3, $Pre_Oferta_P->__get("Id_Corporativo_Actual"));
            $stm->bindValue(4, $Pre_Oferta_P->__get("Basico_Neto_Operador1"));
            $stm->bindValue(5, $Pre_Oferta_P->__get("Basico_Neto_Operador2"));
            $stm->bindValue(6, $Pre_Oferta_P->__get("Valor_Neto_Operador1"));
            $stm->bindValue(7, $Pre_Oferta_P->__get("Valor_Bruto_Operador2"));
            $stm->bindValue(8, $Pre_Oferta_P->__get("Bono_Activacion"));
            $stm->bindValue(9, $Pre_Oferta_P->__get("Valor_Neto_Operador2"));
            $stm->bindValue(10, $Pre_Oferta_P->__get("Total_Ahorro"));
            $stm->bindValue(11, $Pre_Oferta_P->__get("Reduccion_Anual"));
            $stm->bindValue(12, $Pre_Oferta_P->__get("Valor_Mes_Promedio"));
            $stm->bindValue(13, $Pre_Oferta_P->__get("Ahorro_Mensual_Promedio"));
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarDBLAnterior(int $Id_DBL)
    {
        $sql = "INSERT INTO corporativos_anteriores (Id_DBL) VALUES (?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
            $respuesta = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                if ($respuesta) {
                    $sql2 = "SELECT Id_Corporativo_Anterior FROM corporativos_anteriores ORDER BY 1 DESC LIMIT 1";
                    try {
                        $stm = $this->db->prepare($sql2);
                        $stm->execute();
                        $res = $stm->fetch(PDO::FETCH_ASSOC);
                        $Id_Corporativo_Anterior = (int) $res['Id_Corporativo_Anterior'];
                        return $Id_Corporativo_Anterior;
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    return $respuesta;
                }
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
    public function RegistrarDBLActual(int $Id_DBL)
    {
        $sql = "INSERT INTO corporativos_Actuales (Id_DBL) VALUES (?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Id_DBL);
            $respuesta = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                if ($respuesta) {
                    $sql2 = "SELECT Id_Corporativo_Actual FROM corporativos_actuales ORDER BY 1 DESC LIMIT 1";
                    try {
                        $stm = $this->db->prepare($sql2);
                        $stm->execute();
                        $res = $stm->fetch(PDO::FETCH_ASSOC);
                        $Id_Corporativo_Actual = (int) $res['Id_Corporativo_Actual'];
                        return $Id_Corporativo_Actual;
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                } else {
                    return $respuesta;
                }
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarAclaraciones(int $Id_Pre_Oferta, string $texto)
    {
        $sql = "INSERT INTO aclaraciones (Aclaracion, Id_Pre_Oferta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $texto);
            $stm->bindValue(2, $Id_Pre_Oferta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function RegistrarNotas(int $Id_Pre_Oferta, string $texto)
    {
        $sql = "INSERT INTO notas (Nota, Id_Pre_Oferta) VALUES (?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $texto);
            $stm->bindValue(2, $Id_Pre_Oferta);
            $respuesta = $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return $respuesta;
            } else {
                return $stm->errorInfo();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
