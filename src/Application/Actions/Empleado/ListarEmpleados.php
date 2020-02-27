<?php

declare(strict_types=1);

namespace App\Application\Actions\Empleado;

use Psr\Http\Message\ResponseInterface as Response;

class ListarEmpleados extends EmpleadoAction
{

    protected function action(): Response
    {

        $parametro = $this->request->getQueryParams();

        if ($parametro != NULL) {

            $empleados = $this->EmpleadoRepository->FiltrarEmpleados($parametro['palabra']);
        } else {

            $empleados = $this->EmpleadoRepository->ListarEmpleados();
        }

        if ($empleados == NULL) {

            return $this->respondWithData(["results" => $empleados]);
        } else {
            $roles  = $this->EmpleadoRepository->ListarRoles();

            $lista = [];

            foreach ($roles as $rol) {

                $itemLista = [
                    "text" => $rol['Nombre'],
                    "children" => []
                ];

                foreach ($empleados as $item) {


                    if ($rol['Nombre'] == $item['Rol']) {

                        $children = [
                            "id" => $item['Id_Empleado'],
                            "text" => $item['Nombre'] . " - " . $item['Documento']
                        ];

                        array_push($itemLista['children'], $children);
                    }
                }

                if ($itemLista['children'] != NULL) {
                    array_push($lista, $itemLista);
                }
            }
        }

        return $this->respondWithData(["results" => $lista]);
    }
}
