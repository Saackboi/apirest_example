<?php

class ControladorCursos
{

    /**
     * Petición POST para crear un curso
     */
    public function create()
    {
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
