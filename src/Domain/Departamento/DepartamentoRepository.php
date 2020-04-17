<?php
declare(strict_types=1);

namespace App\Domain\Departamento;

interface DepartamentoRepository {

    public function RegistrarDepartamento(Departamento $Departamento);

    public function ListarDepartamento();

    public function CambiarEstado(int $Id_Departamento, int $Estado);

    public function ObtenerDatosDepartamento(int $Id_Departamento);

    public function ValidarDepartamentoEliminar(int $Id_Departamento);

    public function EliminarDepartamento(int $Id_Departamento);

    public function ConsultarDepartamentosPais(int $Id_Pais);

    public function EditarDepartamento(Departamento $Departamento);
}