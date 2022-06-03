<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ERROR | E_PARSE | E_NOTICE);

include("./System/Model.php");
include("./Models/Example.php");


class ExampleController
{
    public function __construct()
    {

    }


    public function index()
    {
        $proveedores = (new Example)->where("estado","=","1")->get();

    
        return view("views.index", compact("proveedores"));
    }

    public function listar(Request $request)
    {

        $cantidadRegistros  = $request->input("cantidadRegistros");
        $paginaActual       = $request->input("paginaActual");
        // $txtBuscar          = $request["txtBuscar"];

        $data = (new Example)
            ->where("estado","=","1")
            ->paginate($paginaActual,$cantidadRegistros);

        $registros = $data["data"];
        $pagination = $data["pagination"];

        return response()->json(view("views.listado",compact("registros","pagination")));

    }

    
    public function create()
    {
    
      
    }   



    public function store(Request $request)
    {

        try{

    
            return response()->json(array(
                "mensaje" => "Se guardo con éxito",
            ));

        }catch(Exception $e){


            return response()->json(array(
                "mensaje" => "No se pudo guardar con éxito",
                "error" => $e->getMessage(),
                "line" => $e->getLine()
            ));
        }


            
        
    }
    


    public function edit(Request $request)
    {
        
    }


    public function update(Request $request)
    {
    
        try{
           
            return response()->json(array(
                "mensaje" => "Se guardo con éxito",
            ));

        }catch(Exception $e){


            return response()->json(array(
                "mensaje" => "No se pudo guardar con éxito",
                "error" => $e->getMessage(),
                "line" => $e->getLine()
            ));
        }

    }

    public function destroy(Request $request)
    {


        return response()->json(array("mensaje" => "El registro se ha eliminado con éxito"));
    
    }



}



$controller = new ExampleController();
include "System/Start.php";