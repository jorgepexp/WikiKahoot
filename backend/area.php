<?php
require_once 'clases/respuestas.class.php';
require_once 'clases/area.class.php';
require_once './helpers/cors.php';

$_respuestas = new respuestas;
$_area = new area;
$_cors = new cors;

$_cors->cors();

if($_SERVER['REQUEST_METHOD'] == "GET"){
    $listaArea = $_area->listaArea();
    print_r($listaArea);
    http_response_code(200);
}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al controlador
    $datosArray = $_area->post($postBody);
    //devolvemos una respuesta
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    echo "hola put";
}else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    echo "hola delete";
}else{
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}

?>