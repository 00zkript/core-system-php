<?php 

function path_view($view){
    $nameView = str_replace(".","/",$view).".php";

    return APP_PATH."Views/".$nameView;
}


function view($view,$data = array())
{
    foreach ($data as $key =>  $value) {
        $$key = $value;
    }


    require( path_view($view) );
}


function response()
{
    return (new Response);
}

function abortDafault($status = 404,$message = 'NOT FOUND'){

    ?>
        <style>
            body{
                background-color: black;
                color: white;
            }

            h1{
                font-size: 50px;
            }
            .cuerpo{
                padding: 250px;
                text-align: center;
            }
        </style>
        <div class="cuerpo">

            <h1><?=$status?> /  <?=$message?></h1>
            
        </div>

    <?php 

}


function abort($status = 404,$message = "Not Found"){
    $error = response()->HTTPStatus($status);
    $messageDafault = str_replace("HTTP/1.1 $status ","",$error["error"]);

    $view = "errors.error".$status;
    $data = array();
    $message = empty($message) ? $messageDafault : $message;

    if(!file_exists(path_view($view))){
        abortDafault($status,$message);
        return false;
    }

    if(gettype($message) == "array" ){
        $data = empty($message) ? [
            "message" => $messageDafault
        ] : $message;
    }else{
        $data = array(
            "message" => $message
        );
    }
    
    

    return view($view,$data);
}

function dump($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    
}


function dd($data)
{
    dump($data);
    exit;
    
}


function dump_log($data){
    var_dump($data)."\n";
}

function dd_log($data){
    var_dump($data);
    exit;
}