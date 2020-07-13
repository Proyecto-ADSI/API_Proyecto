<?php

declare(strict_types=1);

namespace App\Domain\Cliente;

interface ClienteRepository
{

    public function ListarCliente();

    public function ObtenerCliente(int $Id_Cliente);

    public function RegistrarCliente(Cliente $Cliente);

    public function EditarCliente(Cliente $Cliente);

    public function EliminarCliente(int $Id_Cliente);

    public function ValidarEstadoCliente(int $Id_Cliente);

    public function ValidarEliminarCliente(int $Id_Cliente);

    public function CambiarEstadoCliente(int $Id_Cliente, int $Estado);

    public function ConsultarUltimoRegistrado();

    public function ImportarClientes(ClienteImportado $Cliente);

    public function ListarClienteImportados();

    public function ValidarUbicacionCliente(?string $Municipio, ?string $Lugar);

    public function ValidarOperadorCliente(string $operador);

    public function ValidarCliente(string $texto);
}
