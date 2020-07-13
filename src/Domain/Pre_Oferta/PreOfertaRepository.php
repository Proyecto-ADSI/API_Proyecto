<?php

declare(strict_types=1);

namespace App\Domain\Pre_Oferta;

interface PreOfertaRepository
{

    public function RegistrarPreOferta(PreOferta $AT);

    public function ListarPreOfertas();

    public function ConsultarUltimoRegistrado();

    public function RegistrarPropuestas(int $Cantidad_Lineas, int $Id_Linea_Movil);

    public function RegistrarPreOfertaEstandar(int $Id_Pre_Oferta, int $Id_Propuesta);

    public function ConsultarUltimaPropuestaRegistrada();

    public function RegistrarAclaraciones(int $Id_Pre_Oferta, string $texto);

    public function RegistrarNotas(int $Id_Pre_Oferta, string $texto);

    public function RegistrarPreOfertaPersonalizada(PreOferta_P $Pre_Oferta_P);

    public function RegistrarDBLActual(int $Id_DBL);

    public function RegistrarDBLAnterior(int $Id_DBL);

    public function ObtenerPreOfertaEstandar(int $Id_Pre_Oferta);
    
    public function ObtenerPreOfertaPersonalizada(int $Id_Pre_Oferta);

    public function ObtenerAclaraciones(int $Id_Pre_Oferta);

    public function ObtenerNotas(int $Id_Pre_Oferta);
}
