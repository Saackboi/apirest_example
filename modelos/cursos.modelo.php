<?php
require_once "conexion.php";

class ModeloCursos
{

    /**
     * Selecciona todos los registros de la tabla de cursos.
     *
     * @param string $tabla El nombre de la tabla.
     * @return array Un array de objetos con todos los cursos.
     */
    static public function index($tabla, $tabla2)
    {

        $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.titulo, $tabla.descripcion, $tabla.instructor, $tabla.imagen, $tabla.precio, $tabla.id_creador, $tabla2.primer_nombre, $tabla2.primer_apellido FROM $tabla INNER JOIN $tabla2 ON $tabla.id_creador = $tabla2.id");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt->null;
    }

    /**
     * Inserta un nuevo curso en la base de datos.
     *
     * @param string $tabla El nombre de la tabla.
     * @param array $datos Los datos del curso a crear.
     * @return string Retorna "ok" si la operación fue exitosa, de lo contrario imprime la información del error.
     */
    static public function create($tabla, $datos)
    {

        $stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(titulo, descripcion, instructor, imagen, precio, id_creador, created_at, updated_at) VALUES (:titulo, :descripcion, :instructor, :imagen, :precio, :id_creador, :created_at, :updated_at)");

        $stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt->bindParam(":id_creador", $datos["id_creador"], PDO::PARAM_STR);
        $stmt->bindParam(":created_at", $datos["created_at"], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
        }

        $stmt = close();

        $stmt = null;
    }

    /**
     * Selecciona un curso específico por su ID.
     *
     * @param string $tabla El nombre de la tabla.
     * @param int $id El ID del curso a mostrar.
     * @return array Un array de objetos con los datos del curso.
     */
    static public function show($tabla, $tabla2, $id)
    {

        $stmt = Conexion::conectar()->prepare("SELECT $tabla.id, $tabla.titulo, $tabla.descripcion, $tabla.instructor, $tabla.imagen, $tabla.precio, $tabla.id_creador, $tabla2.primer_nombre, $tabla2.primer_apellido FROM $tabla INNER JOIN $tabla2 ON $tabla.id_creador = $tabla2.id WHERE $tabla.id=:id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);

        $stmt->close();

        $stmt->null;
    }

    /**
     * Actualiza un curso existente en la base de datos.
     *
     * @param string $tabla El nombre de la tabla.
     * @param array $datos Los datos del curso a actualizar, incluyendo el ID.
     * @return string Retorna "ok" si la actualización fue exitosa, "error" en caso contrario.
     */
    static public function update($tabla, $datos)
    {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET titulo = :titulo, descripcion = :descripcion, instructor = :instructor, imagen = :imagen, precio = :precio, updated_at = :updated_at WHERE id = :id");

        $stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
        $stmt->bindParam(":titulo", $datos["titulo"], PDO::PARAM_STR);
        $stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
        $stmt->bindParam(":instructor", $datos["instructor"], PDO::PARAM_STR);
        $stmt->bindParam(":imagen", $datos["imagen"], PDO::PARAM_STR);
        $stmt->bindParam(":precio", $datos["precio"], PDO::PARAM_STR);
        $stmt->bindParam(":updated_at", $datos["updated_at"], PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt = null;
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
            $stmt = null;
            return "error";
        }
    }

    /**
     * Elimina un curso de la base de datos por su ID.
     *
     * @param string $tabla El nombre de la tabla.
     * @param int $id El ID del curso a eliminar.
     * @return string Retorna "ok" si la eliminación fue exitosa, "error" en caso contrario.
     */
    static public function delete($tabla, $id)
    {
        $stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id");

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt = null;
            return "ok";
        } else {
            print_r(Conexion::conectar()->errorInfo());
            $stmt = null;
            return "error";
        }
    }
}
