<?php

declare(strict_types=1);

namespace App\Application\Actions\Usuario;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\UploadedFileInterface;

class CargarImagenUsuario extends UsuarioAction
{

    protected function action(): Response
    {
        $directory = 'C:\Users\alexx\Desktop\Proyecto\Cliente_Proyecto\assets\images\usuarios';

        $uploadedFiles = $this->request->getUploadedFiles();

        if (empty($uploadedFiles)) {

            // $mensaje = ["ok" => false];
            // $json = json_encode($mensaje, JSON_PRETTY_PRINT);
            // $this->response->withHeader('Content-Type', 'application/json');
            // $this->response->getBody()->write($json);

            return $this->respondWithData(["ok" => false]);

        } else {

            $uploadedFile = $uploadedFiles['Img_Usuario'];

            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                // $filename = moveUploadedFile($directory, $uploadedFile);

                $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
                $basename = bin2hex(random_bytes(8));
                $filename = sprintf('%s.%0.8s', $basename, $extension);

                $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

                // $mensaje = ["ok" => true,"pathArchivo"=>  $filename];
                // $json = json_encode($mensaje, JSON_PRETTY_PRINT);
                // $this->response->getBody()->write($json);
                // $this->response->withHeader('Content-Type', 'application/json');

               return $this->respondWithData(["ok" => true, "pathArchivo" =>  $filename]);
            }else{

               return $this->respondWithData(["ok" => false]);
            }
        }

        // function moveUploadedFile($directory, UploadedFileInterface $uploadedFile)
        // {
        //     $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        //     $basename = bin2hex(random_bytes(8));
        //     $filename = sprintf('%s.%0.8s', $basename, $extension);

        //     $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        //     return $filename;
        // }
    }
}
