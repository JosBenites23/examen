<?php

require_once __DIR__ . '/../settings/client.php';

class Peliculas{

    private $id;
    private $titulo;
    private $director;
    private $categoria;
    private $duracion_minutos;

    private $nombre_tabla = "peliculas";

    private $conexion;

    public function __construct(){
        $database = new db();

        $this -> conexion = $database -> connection();
    }

    public function __destruct(){
        $this -> conexion = null;
    }

    public function create($titulo, $director, $categoria, $duracion_minutos){
        try{
            //preparar la consulta
            $sql = "INSERT INTO $this->nombre_tabla (titulo, director, categoria,duracion_minutos) VALUES(:titulo, :director, :categoria, :duracion_minutos)";

            //crear una sentencia preparada
            $prep = $this->conexion->prepare($sql);

            //vincular los parametros recibidos con la sentencia sql, esto evita inyecciones sql
            $prep->bindParam(':titulo', $titulo);
            $prep->bindParam(':director', $director);
            $prep->bindParam(':categoria', $categoria); // Bind hashed contrasena
            $prep->bindParam(':duracion_minutos', $duracion_minutos);

            // ejecutamos la sentencia
            return $prep->execute(); // execute returns true on success

        }catch(PDOException $e){
            //se usa la funcion die en este proyecto para detener la ejecucion y mostrar el error, en un entorno real se registraria el error en lugar de mostrarlo
            die('Error al crear pelicula: '. $e->getMessage());
        }
    }

}