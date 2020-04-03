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
use App\Application\Actions\Usuario\CambiarEstadoUsuario;
use App\Application\Actions\Usuario\EliminarUsuario;
use App\Application\Actions\Usuario\CargarImagenUsuario;

// Empleados
use App\Application\Actions\Empleado\ListarEmpleados;


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
use App\Application\Actions\Departamento\ConsultarDepartamentosPaisAction;
use App\Application\Actions\Departamento\EditarDepartamentoAction;
use App\Application\Actions\Departamento\CambiarEstadoDepartamentoAction;
//Municipio
use App\Application\Actions\Municipio\ListarMunicipioAction;
use App\Application\Actions\Municipio\RegistrarMunicipioAction;
use App\Application\Actions\Municipio\ObtenerDatosMunicipioAction;
use App\Application\Actions\Municipio\EditarMunicipioAction;
use App\Application\Actions\Municipio\ConsultarMunicipiosDepartamentoAction;
use App\Application\Actions\Municipio\CambiarEstadoMunicipioAction;
//SubTipo
use App\Application\Actions\SubTipo\ListarSubTipoAction;
use App\Application\Actions\SubTipo\RegistrarSubTipoAction;
use App\Application\Actions\SubTipo\ObtenerSubTipoAction;
use App\Application\Actions\SubTipo\EditarSubTipoAction;
use App\Application\Actions\SubTipo\CambiarEstadoSubTipoAction;
//BarriosVeredas
use App\Application\Actions\BarriosVeredas\ListarBarriosVeredasAction;
use App\Application\Actions\BarriosVeredas\RegistrarBarriosVeredasAction;
use App\Application\Actions\BarriosVeredas\ObtenerBarriosVeredasAction;
use App\Application\Actions\BarriosVeredas\EditarBarriosVeredasAction;
use App\Application\Actions\BarriosVeredas\CambiarEstadoBarriosVeredasAction;
use App\Application\Actions\BarriosVeredas\ConsultarBarriosVeredasMunicipioAction;

//Turnos
use App\Application\Actions\Turnos\ListarTurnosAction;
use App\Application\Actions\Turnos\RegistrarTurnosAction;
use App\Application\Actions\Turnos\ObtenerDatosTurnosAction;
use App\Application\Actions\Turnos\EditarTurnosAction;
use App\Application\Actions\Turnos\CambiarEstadoTurnosAction;
//Rol
use App\Application\Actions\Rol\CambiarEstadoRolAction;
use App\Application\Actions\Rol\EditarRolAction;
use App\Application\Actions\Rol\ListarRolAction;
use App\Application\Actions\Rol\ObtenerDatosRolAction;
use App\Application\Actions\Rol\RegistrarRolAction;
//Operador
use App\Application\Actions\Operador\CambiarEstadoOperadorAction;
use App\Application\Actions\Operador\EditarOperadorAction;
use App\Application\Actions\Operador\ListarOperadorAction;
use App\Application\Actions\Operador\ObtenerOperadorAction;
use App\Application\Actions\Operador\RegistrarOperadorAction;


// Cliente
use App\Application\Actions\Cliente\RegistrarCliente;
use App\Application\Actions\Cliente\ListarCliente;
use App\Application\Actions\Cliente\ObtenerCliente;
use App\Application\Actions\Cliente\EditarCliente;
use App\Application\Actions\Cliente\ValidarEstadoCliente;
use App\Application\Actions\Cliente\CambiarEstadoCliente;
use App\Application\Actions\Cliente\EliminarCliente;

use Psr\Http\Message\UploadedFileInterface;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;


return function (App $app) {


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

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Binevenido a CallPhone Soft');
        return $response;
    });

    $app->group('/Usuarios', function (Group $group) {
        $group->get('', ListarUsuarios::class);
        $group->get('/{usuario}', ObtenerUsuario::class);
        $group->get('/ValidarUsuario/{usuario}', ValidarUsuario::class);
        $group->get('/EnviarCorreo/{usuario}', EnviarCorreo::class);
        $group->get('/Validacion/Disponible', UsuarioDisponible::class);
        $group->get('/CambiarEstado/{Id_Usuario_CE}/{Estado}', CambiarEstadoUsuario::class);
        $group->post('/Login', LoginAction::class);
        $group->post('', UsuarioRegistro::class);
        $group->get('/ValidarToken/{token}', ValidarToken::class);
        $group->patch('', RestablecerContrasena::class);
        $group->put('', EditarUsuario::class);
        $group->delete('/{Id_Usuario_Eliminar}', EliminarUsuario::class);
        $group->post('/CargarImagenUsuario', CargarImagenUsuario::class);
    });

    $app->group('/Empleados', function (Group $group) {
        $group->get('', ListarEmpleados::class);
    });

    $app->group('/Cliente', function (Group $group) {
        $group->post('', RegistrarCliente::class);
        $group->get('', ListarCliente::class);
        $group->get('/{Id_Cliente}', ObtenerCliente::class);
        $group->get('/ValidarEstado/{Id_Cliente_VE}', ValidarEstadoCliente::class);
        $group->get('/CambiarEstado/{Id_Cliente_CE}/{Estado}', CambiarEstadoCliente::class);
        $group->put('', EditarCliente::class);
        $group->delete('/{Id_Cliente_Eliminar}', EliminarCliente::class);
    });

    $app->group('/Documento', function (Group $group) {
        $group->post('', DocumentoRegistroAction::class);
        $group->get('', ListarDocumento::class);
        $group->get('/ObtenerDatosDocumento/{Id_Documentos}', ObtenerDatosAction::class);
        $group->put('', EditarDocumentoAction::class);
        $group->patch('/{Id_Documentos}/{Estado}', CambiarEstadoAction::class);
    });

    $app->group('/Sexo', function (Group $group) {
        $group->post('', RegistrarSexoAction::class);
        $group->get('', ListarSexoAction::class);
        $group->get('/ObtenerSexo/{Id_Sexo}', ObtenerSexoAction::class);
        $group->put('', EditarSexoAction::class);
        $group->patch('/{Id_Sexo}/{Estado}', CambiarEstadoSexo::class);
    });

    $app->group('/Pais', function (Group $group) {
        $group->post('', RegistrarPaisAction::class);
        $group->get('', ListarPaisAction::class);
        $group->get('/ObtenerPais/{Id_Pais}', ObtenerDatosPaisAction::class);
        $group->put('', EditarPaisAction::class);
        $group->patch('/{Id_Pais}/{Estado}', CambiarEstadoPaisAction::class);
    });

    $app->group('/Departamento', function (Group $group) {
        $group->post('', RegistrarDepartamentoAction::class);
        $group->get('', ListarDepartamentoAction::class);
        $group->get('/ObtenerDepartamento/{Id_Departamento}', ObtenerDatosDepartamentoAction::class);
        $group->get('/ConsultarDepartamento/{Id_Pais}', ConsultarDepartamentosPaisAction::class);
        $group->put('', EditarDepartamentoAction::class);
        $group->patch('/{Id_Departamento}/{Estado}', CambiarEstadoDepartamentoAction::class);
    });

    $app->group('/Municipio', function (Group $group) {
        $group->post('', RegistrarMunicipioAction::class);
        $group->get('', ListarMunicipioAction::class);
        $group->get('/ObtenerMunicipio/{Id_Municipio}', ObtenerDatosMunicipioAction::class);
        $group->get('/ConsultarMunicipio/{Id_Departamento}', ConsultarMunicipiosDepartamentoAction::class);
        $group->put('', EditarMunicipioAction::class);
        $group->patch('/{Id_Municipio}/{Estado}', CambiarEstadoMunicipioAction::class);
    });



    $app->group('/SubTipo', function (Group $group) {
        $group->post('', RegistrarSubTipoAction::class);
        $group->get('', ListarSubTipoAction::class);
        $group->get('/ObtenerSubTipo/{Id_SubTipo_Barrio_Vereda}', ObtenerSubTipoAction::class);
        $group->put('', EditarSubTipoAction::class);
        $group->patch('/{Id_SubTipo_Barrio_Vereda}/{Estado}', CambiarEstadoSubTipoAction::class);
    });
    $app->group('/BarriosVeredas', function (Group $group) {
        $group->post('', RegistrarBarriosVeredasAction::class);
        $group->get('', ListarBarriosVeredasAction::class);
        $group->get('/ObtenerBarriosVereda/{Id_Barrios_Veredas}', ObtenerBarriosVeredasAction::class);
        $group->get('/ConsultarBarriosVeredas/{Id_Municipio}/{Id_SubTipo}', ConsultarBarriosVeredasMunicipioAction::class);
        $group->put('', EditarBarriosVeredasAction::class);
        $group->patch('/{Id_Barrios_Veredas}/{Estado}', CambiarEstadoBarriosVeredasAction::class);
    });
    $app->group('/Turnos', function (Group $group) {
        $group->post('', RegistrarTurnosAction::class);
        $group->get('', ListarTurnosAction::class);
        $group->get('/ObtenerTurnos/{Id_Turno}', ObtenerDatosTurnosAction::class);
        $group->put('', EditarTurnosAction::class);
        $group->patch('/{Id_Turno}/{Estado}', CambiarEstadoTurnosAction::class);
    });

    $app->group('/Rol', function (Group $group) {
        $group->post('', RegistrarRolAction::class);
        $group->get('', ListarRolAction::class);
        $group->get('/ObtenerRol/{Id_Rol}', ObtenerDatosRolAction::class);
        $group->put('', EditarRolAction::class);
        $group->patch('/{Id_Rol}/{Estado}', CambiarEstadoRolAction::class);
    });

    $app->group('/Operador', function (Group $group) {
        $group->post('', RegistrarOperadorAction::class);
        $group->get('', ListarOperadorAction::class);
        $group->get('/ObtenerOperador/{Id_Operador}', ObtenerOperadorAction::class);
        $group->put('', EditarOperadorAction::class);
        $group->patch('/{Id_Operador}/{Estado}', CambiarEstadoOperadorAction::class);
    });
};
