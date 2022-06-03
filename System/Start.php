<?php 

include "Request.php";
include "Response.php";
include "Helper.php";

try{
    
    // if(!isset($_REQUEST["action"])){
    //     throw new Exception("No hay metodo");
    // } 
    
    // $method = $_REQUEST["action"];
    // $method = basename( $_SERVER["PHP_SELF"] );
    $method = basename( $_SERVER["REQUEST_URI"] );

    if(method_exists($controller,$method)){
        $content = file_get_contents('php://input');
        $json = $content == '' ? array() : json_decode($content,true);
        
        $request = array_merge($_REQUEST,$json);

        // $response = $controller->$method($request);
        $response = $controller->$method(new Request($request));
        
        echo $response;
    }else{
        header('HTTP/1.1 405 Method Not Allowed');
        throw new Exception("Metodo invalido");
    }

}catch(Exception $e){

    echo $e->getMessage();

}