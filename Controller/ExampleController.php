<?php


include("./Models/Example.php");


class ExampleController
{
    public function __construct()
    {

    }


    public function index()
    {
        $proveedores = (new Example)->where("estado","=","1")->get();

    
        return view("index", compact("proveedores"));
    }

    public function listar(Request $request)
    {

        $cantidadRegistros  = $request->input("cantidadRegistros");
        $paginaActual       = $request->input("paginaActual");
        $txtBuscar          = $request->input("txtBuscar");

        $data = (new Example)
            ->when(! empty($txtBuscar), function($query) use($txtBuscar) {
                return $query->where("titulo","like","%$txtBuscar%");
            })
            ->where("estado","=","1")
            ->paginate($paginaActual,$cantidadRegistros);

        $registros = $data["data"];
        $pagination = $data["pagination"];

        return response()->json(view("listado",compact("registros","pagination")));

    }

    
    public function create()
    {
        return abort(404);
    }   



    public function store(Request $request)
    {
        $nombre = $request->input("nombre");
    
        try{
            $registro = new Example;
            $registro->nombre = $nombre;
            $registro->save();
    
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
    

    public function show(Request $request)
    {
        $idregistro = $request->input("idregistro");
        $registro = (new Example)->find($idregistro)->toArray();

        if(empty($registro)){
            return response()->json(array(
                "mensaje" => "No se pudo encontrar el registro."
            ),400);
        }

        return response()->json($registro);

    }

    public function edit(Request $request)
    {
        $idregistro = $request->input("idregistro");
        $registro = (new Example)->find($idregistro)->toArray();

        if(empty($registro)){
            return response()->json(array(
                "mensaje" => "No se pudo encontrar el registro."
            ),400);
        }

        return response()->json($registro);

    }


    public function update(Request $request)
    {
        $idregistro = $request->input("idregistro");
        $nombre = $request->input("nombreEditar");
    
        try{
            $registro = (new Example)->find($idregistro);
            $registro->nombre = $nombre;
            $registro->update();
           
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

    public function habilitar(Request $request)
    {
        $idregistro = $request->input("idregistro");
    
        try{
            $registro = (new Example)->find($idregistro);
            $registro->estado = 1;
            $registro->update();
           
            return response()->json(array(
                "mensaje" => "Se habilito con éxito",
            ));

        }catch(Exception $e){


            return response()->json(array(
                "mensaje" => "No se pudo habilitar con éxito",
                "error" => $e->getMessage(),
                "line" => $e->getLine()
            ));
        }

    }

    
    public function inhabilitar(Request $request)
    {
        $idregistro = $request->input("idregistro");
    
        try{
            $registro = (new Example)->find($idregistro);
            $registro->estado = 0;
            $registro->update();
           
            return response()->json(array(
                "mensaje" => "Se inhabilito con éxito",
            ));

        }catch(Exception $e){


            return response()->json(array(
                "mensaje" => "No se pudo inhabilitar con éxito",
                "error" => $e->getMessage(),
                "line" => $e->getLine()
            ));
        }

    }

    public function destroy(Request $request)
    {
        $idregistro = $request->input("idregistro");
    
        try{
            $registro = (new Example)->find($idregistro);
            $registro->delete();
            
            return response()->json(array(
                "mensaje" => "El registro se ha eliminado con éxito"
            ));

        }catch(Exception $e){


            return response()->json(array(
                "mensaje" => "No se pudo inhabilitar con éxito",
                "error" => $e->getMessage(),
                "line" => $e->getLine()
            ));
        }
    
    }


    public function getPosiciones(Request $request)
    {
        $total = (new Example)->select(["count(*) as total"])->first();

        return response()->json([
            "total" =>  $total["total"] + 1
        ]);

    }



}


