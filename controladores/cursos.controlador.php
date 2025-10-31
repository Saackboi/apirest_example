<?php

class ControladorCursos
{

    /**
     * Petición POST para crear un curso
     */
    public function create($datos)
    {
        //VALIDAR CREDENCIALES DEL CLIENTE

        $clientes = ModeloClientes::index("clientes");

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {


            foreach ($clientes as $key => $valueCliente) {
                if (base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW'] == $valueCliente['id_cliente'] . ":" . $valueCliente['llave_secreta'])) {

                    //VALIDAR LOS DATOS ENVIADOS
                    foreach ($datos as $key => $valueDatos) {

                        if (isset($valueDatos) && !preg_match('/^[(\\)\\=\\&\\$\\;\\-\\_\\*\\"\\<\\>\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/i', $valueDatos)) {

                            $json = array(
                                "status" => 404,
                                "detalle" => "Error en el campo " . $key
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }

                    //VALIDAR QUE TITULO Y DESCRIPCIÓN NO ESTEN REPETIDOS

                    $cursos = ModeloCursos::index("cursos");

                    foreach ($cursos as $key => $value) {
                        if ($datos["titulo"] == $value->titulo) {
                            $json = array(
                                "status" => 404,
                                "detalle" => "El título ya existe en la base de datos."
                            );

                            echo json_encode($json, true);

                            return;
                        }

                        if ($datos["descripcion"] == $value->descripcion) {
                            $json = array(
                                "status" => 404,
                                "detalle" => "La descripcion ya existe en la base de datos."
                            );

                            echo json_encode($json, true);

                            return;
                        }
                    }

                    //LLEVAR DATOS AL MODELO

                    $datos = array(
                        "titulo" => $_POST["titulo"],
                        "descripcion" => $_POST["descripcion"],
                        "instructor" => $_POST["instructor"],
                        "imagen" => $_POST["imagen"],
                        "precio" => $_POST["precio"],
                        "id_creador" => $valueCliente["id"],
                        "created_at" => date('Y-m-d h:i:s'),
                        "updated_at" => date('Y-m-d h:i:s')
                    );

                    $create = ModeloCursos::create("cursos", $datos);

                    //RESPUESTA DEL MODELO
                    if ($create == "ok") {

                        $json = array(
                            "status" => 200,
                            "detalle" => "Registro exitoso, su curso ha sido guardado."
                        );

                        echo json_encode($json, true);

                        return;
                    }
                }
            }
        }




        $json = array(
            "detalle" => "Estas en la vista create curso"
        );

        echo json_encode($json, true);
        return;
    }


    /**
     * Petición GET para mostrar todos los cursos
     */
    public function index()
    {

        $clientes = ModeloClientes::index("clientes");



        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {

            foreach ($clientes as $key => $value) {

                if (base64_encode($_SERVER['PHP_AUTH_USER'] . ":" . $_SERVER['PHP_AUTH_PW'] == $value['id_cliente'] . ":" . $value['llave_secreta'])) {

                    $cursos = ModeloCursos::index("cursos");

                    $json = array(

                        "detalle" => $cursos

                    );

                    echo json_encode($json, true);
                    return;
                }
            }
        }
    }

    /**
     * Petición GET para mostrar un curso específico por ID
     */
    public function show($id)
    {
        $json = array(
            "detalle" => "Estas en la vista show curso con id " . $id
        );

        echo json_encode($json, true);
        return;
    }


    /**
     * Petición PUT para actualizar un curso por ID
     */
    public function update($id)
    {
        $json = array(
            "detalle" => "curso actualizado con id " . $id
        );

        echo json_encode($json, true);
        return;
    }

    /**
     * Petición DELETE para eliminar un curso por ID
     */
    public function delete($id)
    {
        $json = array(
            "detalle" => "curso eliminado con id " . $id
        );

        echo json_encode($json, true);
        return;
    }
}
