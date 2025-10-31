<?php

class ControladorClientes
{
    public function create($datos)
    {

        // VALIDAR ENTRADAS
        if (isset($datos["nombre"]) && !preg_match('/^[a-zA-Z-áéíóúÁÉÍÓÚÑ ]+$/', $datos["nombre"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo del nombre. Permitido solo letras"

            );

            echo json_encode($json, true);
            return;
        }

        if (isset($datos["apellido"]) && !preg_match('/^[a-zA-Z-áéíóúÁÉÍÓÚÑ ]+$/', $datos["apellido"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo del apellido. Permitido solo letras"

            );

            echo json_encode($json, true);
            return;
        }

        if (isset($datos["email"]) && !preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $datos["email"])) {
            $json = array(
                "status" => 404,
                "detalle" => "Error en el campo del email. Permitido solo emails validos"

            );

            echo json_encode($json, true);
            return;
        }

        // VALIDAR EMAIL REPETIDO

        $clientes = ModeloClientes::index("clientes");

        foreach ($clientes as $key => $value) {
            if ($value["email"] == $datos["email"]) {
                $json = array(
                    "status" => 404,
                    "detalle" => "El email ya está registrado en el sistema."

                );

                echo json_encode($json, true);
                return;
            }
        }

        //GENERAR CREDENCIALES DEL CLIENTE
        $id_cliente = str_replace("$", "c", crypt($datos["nombre"] . $datos["apellido"] . $datos["email"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

        $llave_secreta = str_replace("$", "a", crypt($datos["email"] . $datos["apellido"] . $datos["nombre"], '$2a$07$afartwetsdAD52356FEDGsfhsd$'));

        $datos = array(
            "nombre" => $datos["nombre"],
            "apellido" => $datos["apellido"],
            "email" => $datos["email"],
            "id_cliente" => $id_cliente,
            "llave_secreta" => $llave_secreta,
            "created_at" => date('Y-m-d h:i:s'),
            "updated_at" => date('Y-m-d h:i:s')
        );


        $create = ModeloClientes::create("clientes", $datos);

        if($create == "ok"){
            $json = array(
                "detalle" => "Cliente creado correctamente",
                "id_cliente" => $id_cliente,
                "llave_secreta" => $llave_secreta
            );

            echo json_encode($json, true);
            return;
        }
    }
}
