<?php

declare(strict_types=1);

namespace App\Domain\Oferta;

interface OfertaRepository
{

    public function RegistrarOferta(Oferta $AT);

    public function ListarOfertas();

    public function RegistrarPropuestas(int $Cantidad_Lineas, int $Id_Linea_Movil);

    public function RegistrarOfertaEstandar(int $Id_Oferta, int $Id_Propuesta);

    public function RegistrarAclaraciones(int $Id_Oferta, string $texto);

    public function RegistrarNotas(int $Id_Oferta, string $texto);

    public function RegistrarOfertaPersonalizada(Oferta_P $_Oferta_P);

    public function RegistrarDBLActual(int $Id_DBL);

    public function RegistrarDBLAnterior(int $Id_DBL);

    public function ObtenerOfertaEstandar(int $Id_Oferta);
    
    public function ObtenerOfertaPersonalizada(int $Id_Oferta);

    public function ObtenerAclaraciones(int $Id_Oferta);

    public function ObtenerNotas(int $Id_Oferta);

    public function ObtenerInfoOfertaAT(int $Id_AT);

    public function ObtenerInfoOfertaVisita(int $Id_Visita);

    public function RegistrarAccionOferta(int $Id_Usuario,int $Id_Oferta, int $Id_Estado_Oferta, string $Mensaje);

    public function ListarAccionesOferta(int $Id_Oferta);
}
