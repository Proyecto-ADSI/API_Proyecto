<?php
declare(strict_types=1);


// use App\Application\Actions\User\ListUsersAction;
// use App\Application\Actions\User\ViewUserAction;

// Usuario
use App\Application\Actions\Usuario\EnviarCorreo;
use App\Application\Actions\Usuario\LoginAction;
use App\Application\Actions\Usuario\RestablecerContrasena;
use App\Application\Actions\Usuario\UsuarioRegistro;
use App\Application\Actions\Usuario\ValidarToken;
use App\Application\Actions\Usuario\ValidarUsuario;
use App\Application\Actions\Usuario\UsuarioDisponible;
// Empleados
use App\Application\Actions\Empleado\ListarEmpleados;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    // $app->group('/users', function (Group $group) {
    //     $group->get('', ListUsersAction::class);
    //     $group->get('/{id}', ViewUserAction::class);
    // });

    $app->group('/Usuarios', function (Group $group) {
        $group->get('/ValidarUsuario/{usuario}',ValidarUsuario::class);
        $group->get('/EnviarCorreo/{usuario}',EnviarCorreo::class);
        $group->get('/Disponible',UsuarioDisponible::class);
        $group->post('/Login', LoginAction::class);
        $group->post('', UsuarioRegistro::class);
        $group->get('/ValidarToken/{token}', ValidarToken::class);
        $group->patch('', RestablecerContrasena::class);
    });

    $app->group('/Empleados', function(Group $group){
        $group->get('',ListarEmpleados::class);
    });

    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });
    
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
};
