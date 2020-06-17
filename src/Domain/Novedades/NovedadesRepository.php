<?php
declare(strict_types=1);

namespace App\Domain\Novedades;

interface NovedadesRepository{

    public function RegistrarNovedad(Novedades $Novedades);

}