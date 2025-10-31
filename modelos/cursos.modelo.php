<?php
    require_once "conexion.php";

    class ModeloCursos{

        //lLAMADO A TABLA PARA RETORNAR LOS DATOS
        static public function index($tabla){

            $stmt =Conexion::conectar()->prepare("SELECT * FROM $tabla");

            $stmt ->execute();

            return $stmt->fetchAll(PDO::FETCH_CLASS);

            $stmt->close();

            $stmt->null;
        }

        //PARA CREAR CURSO
        static public function create($tabla, $datos){

           $stmt =Conexion::conectar()->prepare("INSERT INTO $tabla(titulo, descripcion, instructor, imagen, precio, id_creador, created_at, updated_at) VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :id_creador, :created_at, :updated_at)"); 

            $stmt -> bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
            $stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $stmt -> bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
            $stmt -> bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $stmt -> bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
            $stmt -> bindParam(":id_creador", $datos["id_creador"], PDO::PARAM_STR);
            $stmt -> bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
            $stmt -> bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

            if ($stmt->execute()){
                return "ok";
            } else {
                print_r(Conexion::conectar()->errorInfo());
            }

            $stmt = close();

            $stmt = null;
        }

    }
?>