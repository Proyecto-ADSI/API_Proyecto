<?php
declare(strict_types=1);

namespace App\Domain\Llamada;

interface LlamadaRepository{

    public function ListarLlamada();

    public function ObtenerLlamada(int $Id_Llamada);

    public function RegistrarLlamada(Llamada $Llamada);

    public function EditarLlamada(Llamada $Llamada);

    public function EliminarLlamada(int $Id_Llamada);

    public function CambiarEstadoLlamada(int $Id_Llamada, int $Estado);

    public function ConsultarUltimoRegistrado();
    
}