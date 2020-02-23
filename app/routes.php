<?php
declare(strict_types=1);


// use App\Application\Actions\User\ListUsersAction;
// use App\Application\Actions\User\ViewUserAction;

// Usuario
use App\Application\Actions\Usuario\ListarUsuarios;
use App\Application\Actions\Usuario\ObtenerUsuario;
use App\Application\Actions\Usuario\EnviarCorreo;
use App\Application\Actions\Usuario\LoginAction;
use App\Application\Actions\Usuario\RestablecerContrasena;
use App\Application\Actions\Usuario\UsuarioRegistro;
use App\Application\Actions\Usuario\ValidarToken;
use App\Application\Actions\Usuario\ValidarUsuario;
use App\Application\Actions\Usuario\UsuarioDisponible;
use App\Application\Actions\Usuario\EditarUsuario;

// Empleados
use App\Application\Actions\Empleado\ListarEmpleados;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
//Documento
use App\Application\Actions\Documento\ListarDocumento;
use App\Application\Actions\Documento\DocumentoRegistroAction;
use App\Application\Actions\Documento\ObtenerDatosAction;
use App\Application\Actions\Documento\EditarDocumentoAction;
use App\Application\Actions\Documento\CambiarEstadoAction;
//Sexo
use App\Application\Actions\Sexo\ListarSexoAction;
use App\Application\Actions\Sexo\RegistrarSexoAction;
use App\Application\Actions\Sexo\ObtenerSexoAction;
use App\Application\Actions\Sexo\EditarSexoAction;
use App\Application\Actions\Sexo\CambiarEstadoSexo;
//País
use App\Application\Actions\Pais\ListarPaisAction;
use App\Application\Actions\Pais\RegistrarPaisAction;
use App\Application\Actions\Pais\ObtenerDatosPaisAction;
use App\Application\Actions\Pais\EditarPaisAction;
use App\Application\Actions\Pais\CambiarEstadoPaisAction;
//Departamento
use App\Application\Actions\Departamento\ListarDepartamentoAction;
use App\Application\Actions\Departamento\RegistrarDepartamentoAction;
use App\Application\Actions\Departamento\ObtenerDatosDepartamentoAction;
use App\Application\Actions\Departamento\EditarDepartamentoAction;
use App\Application\Actions\Departamento\CambiarEstadoDepartamentoAction;
//Municipio
use App\Application\Actions\Municipio\ListarMunicipioAction;
use App\Application\Actions\Municipio\RegistrarMunicipioAction;
use App\Application\Actions\Municipio\ObtenerDatosMunicipioAction;
use App\Application\Actions\Municipio\EditarMunicipioAction;
use App\Application\Actions\Municipio\CambiarEstadoMunicipioAction;


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
        $group->get('',ListarUsuarios::class); 
        $group->get('/{usuario}',ObtenerUsuario::class);
        $group->get('/ValidarUsuario/{usuario}',ValidarUsuario::class) ;
        $group->get('/EnviarCorreo/{usuario}',EnviarCorreo::class);
        $group->get('/Validacion/Disponible',UsuarioDisponible::class);
        $group->post('/Login', LoginAction::class);
        $group->post('', UsuarioRegistro::class);
        $group->get('/ValidarToken/{token}', ValidarToken::class);
        $group->patch('', RestablecerContrasena::class);
        $group->put('',EditarUsuario::class);
    });

    $app->group('/Empleados', function(Group $group){
        $group->get('',ListarEmpleados::class);
    });

    $app->group('/Documento', function(Group $group){
        $group->post('',DocumentoRegistroAction::class);
        $group->get('',ListarDocumento::class);
        $group->get('/ObtenerDatos/{Id_Documentos}',ObtenerDatosAction::class);
        $group->put('',EditarDocumentoAction::class);
        $group->patch('/{Id_Documentos}/{Estado}',CambiarEstadoAction::class);
    });

    $app->group('/Sexo', function(Group $group){
        $group->post('',RegistrarSexoAction::class);
        $group->get('',ListarSexoAction::class);
        $group->get('/ObtenerSexo/{Id_Sexo}',ObtenerSexoAction::class);
        $group->put('',EditarSexoAction::class);
        $group->patch('/{Id_Sexo}/{Estado}',CambiarEstadoSexo::class);
    });

    $app->group('/Pais', function(Group $group){
        $group->post('',RegistrarPaisAction::class);
        $group->get('',ListarPaisAction::class);
        $group->get('/ObtenerPais/{Id_Pais}',ObtenerDatosPaisAction::class);
        $group->put('',EditarPaisAction::class);
        $group->patch('/{Id_Pais}/{Estado}',CambiarEstadoPaisAction::class);
    });

    $app->group('/Departamento', function(Group $group){
        $group->post('',RegistrarDepartamentoAction::class);
        $group->get('',ListarDepartamentoAction::class);
        $group->get('/ObtenerDepartamento/{Id_Departamento}',ObtenerDatosDepartamentoAction::class);
        $group->put('',EditarDepartamentoAction::class);
        $group->patch('/{Id_Departamento}/{Estado}',CambiarEstadoDepartamentoAction::class);
    });

    $app->group('/Municipio', function(Group $group){
        $group->post('',RegistrarMunicipioAction::class);
        $group->get('',ListarMunicipioAction::class);
        $group->get('/ObtenerMunicipio/{Id_Municipio}',ObtenerDatosMunicipioAction::class);
        $group->put('',EditarMunicipioAction::class);
        $group->patch('/{Id_Municipio}/{Estado}',CambiarEstadoMunicipioAction::class);
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
