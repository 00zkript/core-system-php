<?php 


function view($view,$data = array())
{
    foreach ($data as $key =>  $value) {
        $$key = $value;
    }
    $base = APP_PATH."Views/";
    $nameView = str_replace(".","/",$view).".php";


    require( $base.$nameView );
}


function response()
{
    return (new Response);
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