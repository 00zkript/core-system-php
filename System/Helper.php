<?php 


function view($view,$data = array())
{
    foreach ($data as $key =>  $value) {
        $$key = $value;
    }
    $base = "./";
    $nameView = str_replace(".","/",$view).".php";


    include( $base.$nameView );
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


?> 