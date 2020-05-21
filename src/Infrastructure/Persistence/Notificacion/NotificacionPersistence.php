<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Notificacion;

use App\Domain\Notificacion\Notificacion;
use App\Domain\Notificacion\NotificacionRepository;
use App\Infrastructure\DataBase;
use Exception;
use PDO;

class NotificacionPersistence implements NotificacionRepository
{

    private $db = null;

    function __construct()
    {
        $database = new DataBase();
        $this->db = $database->getConection();
    }

    public function RegistrarNotificacion(Notificacion $Notificacion){
        $sql = "INSERT INTO Notificaciones (Id_Usuario, Mensaje, Id_Categoria_N) VALUES (?,?,?)";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $Notificacion->__GET("Id_Usuario"));
            $stm->bindValue(2, $Notificacion->__GET("Mensaje"));
            $stm->bindValue(3, $Notificacion->__GET("Id_Categoria_N"));
            $r = $stm->execute();
            $error = $stm->errorCode();
            if ($error === '00000') {
                return  $r;
            } else {
                return $stm->errorInfo();
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    public function ConsultarUltimaNotificacion(){
        $sql = "SELECT MAX(Id_Notificacion) AS Id_Notificacion FROM notificaciones ";

        try {
            $stm = $this->db->prepare($sql);
            $stm->execute();

            $error = $stm->errorCode();
            if ($error === '00000') {
                return  $stm->fetch(PDO::FETCH_ASSOC);
            } else {
                return $stm->errorInfo();
            }
            
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
   
}
