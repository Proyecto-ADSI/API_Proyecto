<?php

declare(strict_types=1);

use App\Domain\AsignacionEmpresas\AsignacionERepository;
use App\Domain\Atencion_Telefonica\AtencionTelefonicaRepository;
use App\Domain\Empleado\EmpleadoRepository;
use App\Domain\User\UserRepository;
use App\Domain\Usuario\UsuarioRepository;
use App\Domain\Documento\DocumentoRepository;
use App\Domain\Sexo\SexoRepository;
use App\Domain\Pais\PaisRepository;
use App\Domain\Departamento\DepartamentoRepository;
use App\Domain\Municipio\MunicipioRepository;
use App\Domain\SubTipo\SubTipoRepository;
use App\Domain\BarriosVeredas\BarriosVeredasRepository;
use App\Domain\Calificacion\CalificacionRepository;
use App\Domain\Cita\CitaRepository;
use App\Domain\Cliente\ClienteRepository;
use App\Domain\Configuracion\ConfiguracionRepository;
use App\Domain\DBL\DBLRepository;
use App\Domain\Doc_Soporte\Doc_SoporteRepository;
use App\Domain\Linea\LineaRepository;
use App\Domain\Lineas_Fijas\Lineas_FijasRepository;
use App\Domain\Llamada\LlamadaRepository;
use App\Domain\Operador\OperadorRepository;
use App\Domain\Plan_Corporativo\Plan_CorporativoRepository;
use App\Domain\Opciones_Predefinidas\Opciones_PredefinidasRepository;
use App\Domain\Turnos\TurnosRepository;
use App\Domain\Rol\RolRepository;
use App\Domain\Llamada_Programada\Llamada_ProgramadaRepository;
use App\Domain\Notificacion\NotificacionRepository;
use App\Domain\Notificaciones_Usuario\Notificaciones_UsuarioRepository;
use App\Domain\Novedades\NovedadesRepository;
use App\Domain\Oferta\OfertaRepository;
use App\Domain\Visitas\VisitasRepository;
use App\Infrastructure\Persistence\AsignacionEmpresas\AsignacionEPersistence;
use App\Infrastructure\Persistence\Atencion_Telefonica\AtencionTelefonicaPersistence;
use App\Infrastructure\Persistence\Empleado\EmpleadoPersistence;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Usuario\UsuarioPersistence;
use App\Infrastructure\Persistence\Documento\DocumentoPersistence;
use App\Infrastructure\Persistence\Sexo\SexoPersistence;
use App\Infrastructure\Persistence\Pais\PaisPersistence;
use App\Infrastructure\Persistence\Departamento\DepartamentoPersistence;
use App\Infrastructure\Persistence\Municipio\MunicipioPersistence;
use App\Infrastructure\Persistence\SubTipo\SubTipoPersistence;
use App\Infrastructure\Persistence\BarriosVeredas\BarriosVeredasPersistence;
use App\Infrastructure\Persistence\Calificacion\CalificacionPersistence;
use App\Infrastructure\Persistence\Cita\CitaPersistence;
use App\Infrastructure\Persistence\Cliente\ClientePersistence;

use App\Infrastructure\Persistence\Configuracion\ConfiguracionPersistence;
use App\Infrastructure\Persistence\DBL\DBLPersistence;
use App\Infrastructure\Persistence\Doc_Soporte\Doc_SoportePersistence;
use App\Infrastructure\Persistence\Linea\LineaPersistence;
use App\Infrastructure\Persistence\Lineas_Fijas\Lineas_FijasPersistence;
use App\Infrastructure\Persistence\Llamada\LlamadaPersistence;
use App\Infrastructure\Persistence\Operador\OperadorPersistence;
use App\Infrastructure\Persistence\Plan_Corporativo\Plan_CorporativoPersistence;
use App\Infrastructure\Persistence\Opciones_Predefinidas\Opciones_PredefinidasPersistence;
use App\Infrastructure\Persistence\Turnos\TurnosPersistence;
use App\Infrastructure\Persistence\Rol\RolPersistence;
use App\Infrastructure\Persistence\Llamada_Programada\Llamada_ProgramadaPersistence;
use App\Infrastructure\Persistence\Notificacion\NotificacionPersistence;
use App\Infrastructure\Persistence\Notificaciones_Usuario\Notificaciones_UsuarioPersistence;
use App\Infrastructure\Persistence\Novedades\NovedadesPersistence;
use App\Infrastructure\Persistence\Oferta\OfertaPersistence;
use App\Infrastructure\Persistence\Visitas\VisitasPersistence;


use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        UsuarioRepository::class => \DI\autowire(UsuarioPersistence::class),
        EmpleadoRepository::class => \DI\autowire(EmpleadoPersistence::class),
        DocumentoRepository::class => \DI\autowire(DocumentoPersistence::class),
        SexoRepository::class => \DI\autowire(SexoPersistence::class),
        PaisRepository::class => \DI\autowire(PaisPersistence::class),
        DepartamentoRepository::class => \DI\autowire(DepartamentoPersistence::class),
        MunicipioRepository::class => \DI\autowire(MunicipioPersistence::class),
        SubTipoRepository::class => \DI\autowire(SubTipoPersistence::class),
        BarriosVeredasRepository::class => \DI\autowire(BarriosVeredasPersistence::class),
        TurnosRepository::class => \DI\autowire(TurnosPersistence::class),
        OperadorRepository::class => \DI\autowire(OperadorPersistence::class),
        RolRepository::class => \DI\autowire(RolPersistence::class),
        ClienteRepository::class => \DI\autowire(ClientePersistence::class),
        DBLRepository::class => \DI\autowire(DBLPersistence::class),
        Plan_CorporativoRepository::class => \DI\autowire(Plan_CorporativoPersistence::class),
        Doc_SoporteRepository::class => \DI\autowire(Doc_SoportePersistence::class),
        LineaRepository::class => \DI\autowire(LineaPersistence::class),
        Lineas_FijasRepository::class => \DI\autowire(Lineas_FijasPersistence::class),
        CalificacionRepository::class => \DI\autowire(CalificacionPersistence::class),
        Opciones_PredefinidasRepository::class => \DI\autowire(Opciones_PredefinidasPersistence::class),
        LlamadaRepository::class => \DI\autowire(LlamadaPersistence::class),
        CitaRepository::class => \DI\autowire(CitaPersistence::class),
        Llamada_ProgramadaRepository::class => \DI\autowire(Llamada_ProgramadaPersistence::class),
        NotificacionRepository::class => \DI\autowire(NotificacionPersistence::class),
        Notificaciones_UsuarioRepository::class => \DI\autowire(Notificaciones_UsuarioPersistence::class),
        NovedadesRepository::class => \DI\autowire(NovedadesPersistence::class),
        VisitasRepository::class => \DI\autowire(VisitasPersistence::class),
        AtencionTelefonicaRepository::class => \DI\autowire(AtencionTelefonicaPersistence::class),
        OfertaRepository::class => \DI\autowire(OfertaPersistence::class),
        ConfiguracionRepository::class => \DI\autowire(ConfiguracionPersistence::class),
        AsignacionERepository::class => \DI\autowire(AsignacionEPersistence::class),
    ]);
};
