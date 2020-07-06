<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use App\Domain\Empleado\Empleado;
use App\Domain\Usuario\Usuario;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Psr\Http\Message\ResponseInterface as Response;

class UsuarioRegistro extends UsuarioAction
{
    protected function action(): Response
    {
        $campos = $this->getFormData();

        $Id_Empleado = NULL;

        if ($campos->SeleccionarEmpleado) {
            $Id_Empleado = (int) $campos->Id_Empleado;
        } else {

            $empleado = new Empleado(
                0,
                null,
                null,
                $campos->Nombre,
                null,
                $campos->Email,
                null,
                null,
                $campos->Imagen,
                null,
                0
            );

            if ($campos->RegistrarEmpleado) {

                $empleado->__set("Apellidos", $campos->Apellidos);
                $empleado->__set("Tipo_Documento", $campos->Tipo_Documento);
                $empleado->__set("Documento", $campos->Documento);
                $empleado->__set("Sexo", $campos->Sexo);
                $empleado->__set("Celular", $campos->Celular);
                $empleado->__set("Turno", $campos->Turno);

                $this->EmpleadoRepository->RegistrarEmpleado($empleado);
                $respuesta = $this->EmpleadoRepository->ConsultarUltimoEmpleado();
                $Id_Empleado = (int) $respuesta['Id_Empleado'];
            } else if ($campos->RegistrarAsesorExterno) {

                $this->EmpleadoRepository->RegistrarEmpleado($empleado);
                $respuesta = $this->EmpleadoRepository->ConsultarUltimoEmpleado();
                $Id_Empleado = (int) $respuesta['Id_Empleado'];
            }
        }
        //Encriptar contraseña
        $Contrasena = password_hash($campos->Contrasena, PASSWORD_BCRYPT);

        $usuario = new Usuario(
            0,
            $Id_Empleado,
            $campos->Usuario,
            $Contrasena,
            $campos->Rol
        );

        $respuesta = $this->usuarioRepository->RegistrarUsuario($usuario);
        $Info_Usuario = $this->usuarioRepository->ConsultarUltimoRegistrado();
        $Id_Usuario = (int) $Info_Usuario["Id_Usuario"];

        if ($campos->RegistrarEmpleado) {

            // Enviar correo de validación email.
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";

            $Email = $campos->Email;
            $NombreEmpleado = $campos->Nombre;
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_OFF;                         // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'proyecto.adsi2019@gmail.com';          // SMTP usuario
                $mail->Password   = 'ADSI1824992';                          // SMTP contraseña
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to


                //Correo 
                $mail->setFrom('proyecto.adsi2019@gmail.com', 'Proyecto SENA');     //Correo que envía el mensaje
                $mail->addAddress($Email, $NombreEmpleado);                        // Correo que recibe el mensaje

                //Crear Token
                $token = bin2hex(random_bytes(30));
                $this->usuarioRepository->AgregarToken($token, $Id_Usuario);

                // Contenido
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Validar correo';
                $mail->Body    = 'Hola ' . $NombreEmpleado . ' gracias por registrarte en Call Phone Soft, ingresa al siguiente link para validar tu correo y poder iniciar sesión <a href="http://localhost:3000/ValidarCorreo?token=' . $token . '">Validar correo</a>';


                if ($mail->send()) {

                    return $this->respondWithData(["ok" => true]);
                } else {

                    return $this->respondWithData(["ok" => false]);
                }
            } catch (Exception $e) {

                return $this->respondWithData(["ok" => false, "Error" => "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}"]);
            }
        } else {

            $this->usuarioRepository->CambiarEstadoUsuario($Id_Usuario, 1);
        }

        return $this->respondWithData(["ok" => $respuesta]);
    }
}
