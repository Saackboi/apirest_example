<?php
// DETECTAR URL
$arrayRutas = explode("/", $_SERVER['REQUEST_URI']);

// CUANDO NO SE HACE PETICIÓN A LA API
if (count(array_filter($arrayRutas)) == 2) {

    $json = array(

        "detalle" => "No encontrado"

    );

    echo json_encode($json, true);

    // CUANDO PASAMOS INDICE EN LA URL

} else if (count(array_filter($arrayRutas)) == 3) {

    // CUANDO EL ÍNDICE ES CURSOS

    if (array_filter($arrayRutas)[3] == "cursos") {

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            //Capturar datos
            $datos = array(
                "titulo" => $_POST["titulo"],
                "descripcion" => $_POST["descripcion"],
                "instructor" => $_POST["instructor"],
                "imagen" => $_POST["imagen"],
                "precio" => $_POST["precio"],
            );


            $cursos = new ControladorCursos();
            $cursos->create($datos);




        } else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
            $cursos = new ControladorCursos();
            $cursos->index();
        }
    }

    // CUANDO EL ÍNDICE ES REGISTRO

    else if (array_filter($arrayRutas)[3] == "registro") {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            //DATOS DEL CLIENTE
            $datos = array(
                "nombre" => $_POST["nombre"],
                "apellido" => $_POST["apellido"],
                "email" => $_POST["email"]
            );

            $clientes = new ControladorClientes();
            $clientes->create($datos);
        }
    } else {
        $json = array(

            "detalle" => "No encontrado"

        );

        echo json_encode($json, true);
    }
} else {
    if (array_filter($arrayRutas)[3] == "cursos" && is_numeric(array_filter($arrayRutas)[4])) {

        //PETICION GET
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
            $cursos = new ControladorCursos();
            $cursos->show(array_filter($arrayRutas)[4]);
        }

        // PETICION PUT
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            $editarCursos = new ControladorCursos();
            $editarCursos->update(array_filter($arrayRutas)[4]);
        }

        //PETICION DELETE
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $borrarCursos = new ControladorCursos();
            $borrarCursos->delete(array_filter($arrayRutas)[4]);
        }
    }
}
