<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Visitas;

use App\Domain\Visitas\Visitas;
use App\Domain\Visitas\VisitasRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class VisitasPersistence implements VisitasRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarVisitas(Visitas $Visitas)
    {
        $sql = "INSERT INTO visitas(Tipo_Visita,Id_Asesor,Id_Cita) VALUES (?,?,?)";

        try {

            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Visitas->__GET("Tipo_Visita"));
            $stm->bindValue(2, $Visitas->__GET("Id_Asesor"));
            $stm->bindValue(3, $Visitas->__GET("Id_Cita"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

}
