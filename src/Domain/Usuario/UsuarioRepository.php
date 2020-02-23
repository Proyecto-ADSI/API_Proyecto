<?php
declare(strict_types=1);

namespace App\Domain\Usuario;

interface UsuarioRepository{

    public  function ListarUsuarios();

    public  function ObtenerUsuario(int $Id_Usuario);

    public function login(string $usuario);

    public function RegistrarUsuario(Usuario $login);
    
    public function AgregarToken(string $token, int $Id_Usuario);

    public function ValidarToken(string $token);

    public function EliminarToken(int $Id_Usuario);

    public function RestablecerContrasena(int $Id_Usuario, string $contrasena);

    public function ValidarUsuario(string $usuario);
}  