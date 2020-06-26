<?php

declare(strict_types=1);

namespace App\Application\Actions\Operador;

use Psr\Http\Message\ResponseInterface as Response;

class CargarImagenOperador extends OperadorAction
{

    protected function action(): Response
    {
        $directory = $_SERVER['DOCUMENT_ROOT'] . '\\Images\\Usuarios';

        $uploadedFiles = $this->request->getUploadedFiles();

        if (empty($uploadedFiles)) {

            return $this->respondWithData(["ok" => false]);
        } else {

            $uploadedFile = $uploadedFiles['Img_Operador'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                $basename = bin2hex(random_bytes(8));
                $filename = sprintf('%s.%0.8s', $basename, $extension);

                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                return $this->respondWithData(["ok" => true, "pathArchivo" =>  $filename]);
            } else {

                return $this->respondWithData(["ok" => false]);
            }
        }
    }
}
