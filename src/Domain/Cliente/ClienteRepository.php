<?php
declare(strict_types=1);

namespace App\Domain\Cliente;

interface ClienteRepository{

    public function ListarCliente();

    public function ConsultarCliente(int $id);

    public function RegistrarCliente();

    public function EditarCliente(Cliente $Cliente);

    public function EliminarCliente();

    public function VerDetalleCliente();

    public function CambiarEstado(int $Estado);
    
}