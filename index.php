<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ERROR | E_PARSE | E_NOTICE);


const APP_PATH = __DIR__."/";
const PATH_SYSTEM = APP_PATH."System/";

require(PATH_SYSTEM."Request.php");
require(PATH_SYSTEM."Model.php");
require(PATH_SYSTEM."Controller.php");
require(PATH_SYSTEM."Response.php");
require(PATH_SYSTEM."Helper.php");




$route = $_SERVER["REQUEST_URI"];
// $route = $_SERVER["PHP_SELF"];


try{

    $uri = str_replace("/index.php/","",$route);
    $dataUri = explode("/",$uri);
    
    $findController = array_filter($dataUri,function($item){
        if(preg_match("/Controller/",$item)){
            return $item;
        }
    });

    if(empty($findController)){
        // throw new Exception("Name Controller Not Found.");
        abort(404);
    }

    $arrayDataUri = $dataUri;
    $keyController = array_key_first($findController);
    
    $nameController = $dataUri[$keyController];
    $dirController = implode("/",array_splice($arrayDataUri,0,$keyController+1)).".php";
    $pathController = "Controller/".$dirController;
    
    unset($dataUri[$keyController]);
    $keyMethod  = array_key_first($dataUri);
    $nameMethod = isset($dataUri[$keyMethod]) && $dataUri[$keyMethod] != null ? $dataUri[$keyMethod] : "index";
    $nameMethod = explode("?", $nameMethod)[0];
    
    if(!file_exists($pathController)){
        // throw new Exception("Controller Not Found.");
        abort(404);
    }

    require($pathController);
    
    if(!class_exists($nameController)){
        // throw new Exception("Controller Not Found.");
        abort(404);
    }

    $controller = new $nameController();

    if(!method_exists($controller,$nameMethod)){
        // throw new Exception("Method Not Allowed");
        abort(405,"Method Not Allowed");

    }


    $controller->$nameMethod(new Request);

}catch(Exception $e){

    echo $e->getMessage();

}