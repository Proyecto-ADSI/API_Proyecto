<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Novedades;

use App\Domain\Novedades\Novedades;
use App\Domain\Novedades\NovedadesRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class NovedadesPersistence implements NovedadesRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarNovedad(Novedades $Novedades)
    {
        $sql = "INSERT INTO novedades (Descripcion_Novedad, Estado_Novedad,Id_Cita) VALUES (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Novedades->__GET("Descripcion"));
            $stm->bindValue(2, $Novedades->__GET("Estado_novedad"));
            $stm->bindValue(3, $Novedades->__GET("Id_Cita"));

            return $stm->execute();

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }
}
