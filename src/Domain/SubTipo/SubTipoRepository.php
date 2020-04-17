<?php
declare(strict_types=1);

namespace App\Domain\SubTipo;

interface SubTipoRepository {

    public function RegistrarSubTipo(SubTipo $SubTipo);

    public function ListarSubTipo();

    public function CambiarEstado(int $Id_SubTipo_Barrio_Vereda, int $Estado);

    public function ObtenerDatosSubTipo(int $Id_SubTipo_Barrio_Vereda);

    public function ValidarSubTipoEliminar(int $Id_SubTipo_Barrio_Vereda);

    public function EliminarSubTipo(int $Id_SubTipo_Barrio_Vereda);

    public function EditarSubTipo(SubTipo $SubTipo);
}