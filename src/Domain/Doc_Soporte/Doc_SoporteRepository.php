<?php 

namespace App\Domain\Doc_Soporte;

interface Doc_SoporteRepository
{
    public function RegistrarDocSoporte(Doc_Soporte $Doc_Soporte);

    public function ListarDocSoporte(int $Id_Documentos);

    public function EliminarDocSoporte(int $Id_Documentos);

    public function ConsultarUltimoRegistrado();
}
