<?php

require_once __DIR__ . '/../models/peliculas.class.php';

//verificacion del metodo http
$method = $_SERVER['REQUEST_METHOD'];

//instancia de la clase usuario para usar sus metodos
$peliculas = new Peliculas();

switch($method){
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->titulo) &&
            !empty($data->director) &&
            !empty($data->categoria) && 
            !empty($data->duracion_minutos)
        ) {
            if ($peliculas->create($data->titulo, $data->director, $data->categoria, $data->duracion_minutos)) {
                http_response_code(201);
                echo json_encode(['message' => 'Pelicula registrada exitosamente.']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error: No se pudo registrar la pelicula.']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Datos incompletos.']);
        }
        break;
    }