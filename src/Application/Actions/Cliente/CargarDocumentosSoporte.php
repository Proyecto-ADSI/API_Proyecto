<?php

declare(strict_types=1);

namespace App\Application\Actions\Cliente;

use Psr\Http\Message\ResponseInterface as Response;

class CargarDocumentosSoporte extends ClienteAction
{

    protected function action(): Response
    {
        $directory = $_SERVER['DOCUMENT_ROOT'] . '\\Doc';

        $uploadedFiles = $this->request->getUploadedFiles();

        if (empty($uploadedFiles)) {

            return $this->respondWithData(["ok" => false]);
        } else {

            $docSoporte = [];

            foreach ($uploadedFiles as $uploadedFile) {
                if ($uploadedFile->getError() === UPLOAD_ERR_OK) {

                    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                    $basename = bin2hex(random_bytes(8));
                    $filename = sprintf('%s.%0.8s', $basename, $extension);

                    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                    array_push($docSoporte, $filename);
                } else {

                    return $this->respondWithData(["ok" => false]);
                }
            }
            return $this->respondWithData(["ok" => true, "pathArchivo" => $docSoporte]);
        }
    }
}
