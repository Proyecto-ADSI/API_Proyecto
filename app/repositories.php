<?php
declare(strict_types=1);

use App\Domain\Empleado\EmpleadoRepository;
use App\Domain\User\UserRepository;
use App\Domain\Usuario\UsuarioRepository;
use App\Infrastructure\Persistence\Empleado\EmpleadoPersistence;
use App\Infrastructure\Persistence\User\InMemoryUserRepository;
use App\Infrastructure\Persistence\Usuario\UsuarioPersistence;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        UserRepository::class => \DI\autowire(InMemoryUserRepository::class),
        UsuarioRepository::class => \DI\autowire(UsuarioPersistence::class),
        EmpleadoRepository::class => \DI\autowire(EmpleadoPersistence::class)
    ]);
};
