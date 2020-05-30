<?php
declare(strict_types=1);

namespace App\Domain\Rol;

interface RolRepository {

    public function RegistrarRol(Rol $Rol);

    public function ListarRol();

    public function CambiarEstado(int $Id_Rol, int $Estado);

    public function ObtenerDatosRol(int $Id_Rol);

    public function RolValUsuario(int $Id_Rol);

    public function EditarRol(Rol $Rol);
}