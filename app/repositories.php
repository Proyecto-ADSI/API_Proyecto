<?php
declare(strict_types=1);

use App\Domain\Empleado\EmpleadoRepository;
use App\Domain\User\UserRepository;
use App\Domain\Usuario\UsuarioRepository;
use App\Domain\Documento\DocumentoRepository;
use App\Domain\Sexo\SexoRepository;
use App\Domain\Pais\PaisRepository;
use App\Domain\Departamento\DepartamentoRepository;
use App\Domain\Municipio\MunicipioRepository;


use App\Infrastructure\Persistence\Empleado\EmpleadoPersistence;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Usuario\UsuarioPersistence;
use App\Infrastructure\Persistence\Documento\DocumentoPersistence;
use App\Infrastructure\Persistence\Sexo\SexoPersistence;
use App\Infrastructure\Persistence\Pais\PaisPersistence;
use App\Infrastructure\Persistence\Departamento\DepartamentoPersistence;
use App\Infrastructure\Persistence\Municipio\MunicipioPersistence;
use DI\ContainerBuilder;


use App\Domain\Cliente\ClienteRepository;
use App\Infrastructure\Persistence\Cliente\ClientePersistence;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        UsuarioRepository::class => \DI\autowire(UsuarioPersistence::class),
        EmpleadoRepository::class => \DI\autowire(EmpleadoPersistence::class),
        ClienteRepository::class => \DI\autowire(ClientePersistence::class),
        DocumentoRepository::class => \DI\autowire(DocumentoPersistence::class),
        SexoRepository::class => \DI\autowire(SexoPersistence::class),
        PaisRepository::class => \DI\autowire(PaisPersistence::class),
        DepartamentoRepository::class => \DI\autowire(DepartamentoPersistence::class),
        MunicipioRepository::class => \DI\autowire(MunicipioPersistence::class),
    ]);
};
