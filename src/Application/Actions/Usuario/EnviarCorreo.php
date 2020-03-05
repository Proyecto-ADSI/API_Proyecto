<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Psr\Http\Message\ResponseInterface as Response;


class EnviarCorreo extends UsuarioAction
{
    protected function action(): Response
    {

        // $campos = $this->getFormData();
        // $usuario = $campos->Usuario;

        $usuario  = $this->resolveArg("usuario");


        $respuesta = $this->usuarioRepository->login($usuario);

        if (!$respuesta) {

            return $this->respondWithData(["ok" => false]);
        } else {

            $Id_Empleado = (int) $respuesta['Id_Empleado'];
            $info = $this->EmpleadoRepository->ConsultarEmpleado($Id_Empleado);
      

            // Datos Empleado
            $Email = $info['Email'];
            $NombreEmpleado = $info['Nombre'] . " " . $info['Apellidos'];


            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";

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
                $mail->addAddress($Email, $NombreEmpleado);                                           // Correo que recibe el mensaje

                //Crear Token
                $token = bin2hex(random_bytes(30));
                $Id_Usuario = (int) $respuesta['Id_Usuario'];
                $this->usuarioRepository->AgregarToken($token, $Id_Usuario);

                // Contenido
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Restablecer contraseña';
                $mail->Body    = 'Hola ' . $info['Nombre'] . ' has solicitado restablecer tu contraseña, ingresa al siguiente link para cambiarla <a href="http://127.0.0.1:5500/App/Restablecer/Restablecer.html?token=' . $token . '">Restablecer contraseña</a>';


                if ($mail->send()) {

                    return $this->respondWithData(["ok" => true]);
                } else {

                    return $this->respondWithData(["ok" => false]);
                }
            } catch (Exception $e) {

                return $this->respondWithData(["ok" => false, "Error" => "No se pudo enviar el correo. Mailer Error: {$mail->ErrorInfo}"]);
            }
        }
    }
}
