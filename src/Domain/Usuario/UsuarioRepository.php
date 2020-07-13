<?php

declare(strict_types=1);

namespace App\Domain\Usuario;

interface UsuarioRepository
{
    public  function ListarUsuarios();

    public  function ObtenerUsuario(int $Id_Usuario);

    public function ObtenerCantidadUsuarios(int $Id_Rol, int $Estado);

    public function login(string $usuario);

    public function RegistrarUsuario(Usuario $login);

    public function AgregarToken(string $token, int $Id_Usuario);

    public function ValidarToken(string $token);

    public function EliminarToken(int $Id_Usuario);

    public function RestablecerContrasena(int $Id_Usuario, string $contrasena);

    public function ValidarUsuario(string $usuario);

    public function EditarUsuario(Usuario $usuario);

    public function EditarUsuarioAE(Usuario $usuario);

    public function CambiarEstadoUsuario(int $Id_Usuario, int $estado);

    public function EliminarUsuario(int $Id_Usuario);

    public function ValidarEliminarUsuario(int $Id_Usuario);

    public  function ObtenerUsuarioRol(int $Id_Usuario);

    public function CambiarContrasena(int $Id_Usuario, string $Contrasena);

    public function ConsultarUltimoRegistrado();
}
