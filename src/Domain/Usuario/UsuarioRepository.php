<?php
declare(strict_types=1);

namespace App\Domain\Usuario;

interface UsuarioRepository{

    public function login(string $correo);

    public function registro(Usuario $login);

    public function ultimo();

}