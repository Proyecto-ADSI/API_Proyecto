<?php
declare(strict_types=1);

namespace App\Domain\Documento;

interface DocumentoRepository{

    public function RegistrarDocumento(Documento $Documento);

    public function ListarDocumento();

    public function CambiarEstado(int $Id_Documentos, int $Estado);

    public function ObtenerDatos(int $Id_Documentos);

    public function EditarDocumento(Documento $Documento);
}