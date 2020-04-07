<?php 

namespace App\Domain\Plan_Corporativo;

interface Plan_CorporativoRepository
{
    public function RegistrarPlan_Corporativo(Plan_Corporativo $Plan_Corporativo);

    public function ListarPlan_Corporativo(int $Id_Plan_Corporativo);

    public function EditarPlan_Corporativo(Plan_Corporativo $Plan_Corporativo);

    public function CambiarEstado(int $Id_Plan_Corporativo, int $Estado);

    public function EliminarPlan_Corporativo(int $Id_Plan_Corporativo);

    public function ConsultarUltimoRegistrado();
}
