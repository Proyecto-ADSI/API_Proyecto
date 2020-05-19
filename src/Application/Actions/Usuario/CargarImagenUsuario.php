<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;

class CargarImagenUsuario extends UsuarioAction
{

    protected function action(): Response
    {
        $directory = 'D:\Escritorio\Proyecto\app-node\src\public\assets\images\usuarios';

        $uploadedFiles = $this->request->getUploadedFiles();

        if (empty($uploadedFiles)) {

            return $this->respondWithData(["ok" => false]);

        } else {

            $uploadedFile = $uploadedFiles['Img_Usuario'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                $basename = bin2hex(random_bytes(8));
                $filename = sprintf('%s.%0.8s', $basename, $extension);

                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

               return $this->respondWithData(["ok" => true, "pathArchivo" =>  $filename]);
            }else{

               return $this->respondWithData(["ok" => false]);
            }
        }
    }
}
