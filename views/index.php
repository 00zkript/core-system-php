
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAGINA</title>

    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">



    <style>
        .text-right{
            text-align: right;
        }

        .paginacion {
            margin:20px 0;
        }

        .paginacion ul {
            list-style:none;
            text-align: center;
        }

        .paginacion ul li {
            display:inline-block;
            margin-right:10px;
        }

        .paginacion ul li a {
            display:block;
            padding:10px 20px;
            color:#fff;
            background:#024959;
            text-decoration: none;
        }

        .paginacion ul li a:hover {
            background:#037E8C;
        }

        .paginacion ul li .active {
            background:#037E8C;
            font-weight:bold;
        }

        .mayusculas{
            text-transform: uppercase;
        }

    </style>
</head>
<body class="nav-md">
<div class=" body">

    <?php include "crear.php"; ?> 
    <?php include "editar.php"; ?> 
    <?php include "eliminar.php"; ?> 
    <?php include "habilitar.php"; ?> 
    <?php include "inhabilitar.php"; ?> 
    <?php include "ver.php"; ?> 
    <div class="main_container">
        <div class="right_col" role="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #2a3f54">
                                <p style="font-size: 20px" class="card-title text-center text-white mb-0"> GESTIONAR REGISTROS</p>
                            </div>
                            <div class="card-body">
                                <form id="frmBuscar" >
                                    <div class="row" id="crud">
                                        <div class="col-12 text-right">
                                            <button type="button" id="btnModalCrear" class="btn btn-primary btn-lg"><i class="fa fa-plus"></i> Nuevo registro</button>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cantidadRegistros">Cantidad de registros</label>
                                                <select name="cantidadRegistros" id="cantidadRegistros"  class="form-control">
                                                    <option value="10" selected>10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="9999999">Todos</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label for="txtBuscar">Buscar :</label>
                                            <input type="text" name="txtBuscar" id="txtBuscar" class="form-control" placeholder="N° COMPROBANTE / N° SERIE / RAZÓN SOCIAL ">
                                        </div>

                                        <div class="col-md-2">
                                            <button id="buscar" type="submit" title="Buscar" class="btn btn-secondary my-4"><i class="fa fa-search"></i> </button>
                                        </div>
                                    </div>
                                </form>


                                
                                <div class="row" >

                                    <div class="col-12" id="listado" >

                                    </div>







                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<script type="module" >


    const URL_LISTADO     = "listar";
    const URL_GUARDAR     = "store";
    const URL_VER         = "show";
    const URL_EDIT        = "edit";
    const URL_MODIFICAR   = "update";
    const URL_HABILITAR   = "habilitar";
    const URL_INHABILITAR = "inhabilitar";
    const URL_ELIMINAR    = "destroy";
    const URL_POSICIONES  = "getPosiciones";
    const URL_CARPETA     = location.origin+"/cms/_imgs/banner/";




    const filtros = () => {


        $(document).on("click","a.page-link", function(e) {
            e.preventDefault();
            const url               = e.target.href;
            const paginaActual      = url.split("?pagina=")[1];
            const cantidadRegistros = $("#cantidadRegistros").val();

            listado(cantidadRegistros,paginaActual);
        } )



        $(document).on("change","#cantidadRegistros", function(e) {
            e.preventDefault();
            const paginaActual      = $("#paginaActual").val();
            const cantidadRegistros = e.target.val();

            listado(cantidadRegistros,paginaActual);

        } )



        $(document).on("submit","#frmBuscar", function(e) {
            e.preventDefault();
            const cantidadRegistros = $("#cantidadRegistros").val();
            const paginaActual      = $("#paginaActual").val();

            listado(cantidadRegistros,1);

        } )

    }

    const listado = async (cantidadRegistros = 10,paginaActual = 1) => {
        cargando();

        const form = {
            cantidadRegistros : cantidadRegistros,
            paginaActual : paginaActual,
            txtBuscar : $("#txtBuscar").val().trim(),
        }

        try{
            const response = await axios.post(URL_LISTADO, form );
            const data = response.data;

            stop();
            document.querySelector("#listado").innerHTML = data;


        }catch(error){
            errorCatch(error);
        }


    }

    const modales = () => {

        $(document).on("click","#btnModalCrear", function(e) {
            e.preventDefault();
            $("#frmCrear span.error").remove();
            $("#frmCrear")[0].reset();
            CKEDITOR.instances.contenido.setData('');
            getPositions("crear");
            // $("#frmCrear .selectpicker").selectpicker("refresh");
            $("#modalCrear").modal("show");


        });

        $(document).on("click",".btnModalHabilitar",function(e){
            e.preventDefault();
            var idregistro = $(this).closest('div.dropdown-menu').data('idregistro');
            $("#frmHabilitar input[name=idregistro]").val(idregistro);
            $("#modalHabilitar").modal("show");
        });

        $(document).on("click",".btnModalInhabilitar",function(e){
            e.preventDefault();
            var idregistro = $(this).closest('div.dropdown-menu').data('idregistro');
            $("#frmInhabilitar input[name=idregistro]").val(idregistro);
            $("#modalInhabilitar").modal("show");
        });

        $(document).on("click",".btnModalEliminar",function(e){
            e.preventDefault();
            var idregistro = $(this).closest('div.dropdown-menu').data('idregistro');
            $("#frmEliminar input[name=idregistro]").val(idregistro);
            $("#modalEliminar").modal("show");
        });

        $(document).on("click",".btnModalEditar",function(e){
            e.preventDefault();
            var idregistro = $(this).closest('div.dropdown-menu').data('idregistro');

            cargando('Procesando...');
            axios(URL_EDIT,{ params: {idregistro : idregistro} })
            .then(response => {
                const data = response.data;

                stop();
                $("#frmEditar")[0].reset();
                $("#frmEditar input[name=idregistro]").val(data.idregistro);


                $("#nombreEditar").val(data.nombre);
                CKEDITOR.instances.contenidoEditar.setData(data.contenido);
                getPositions("editar",data.posicion);
                


                $("#imagenEditar").fileinput('destroy').fileinput({
                    dropZoneTitle : 'Arrastre la imagen aquí',
                    initialPreview : [ URL_CARPETA+data.imagen ],
                    initialPreviewConfig : { caption : data.imagen , width: "120px", height : "120px" },
                    // fileActionSettings : { howRemove : false, showUpload : false, showZoom : true, showDrag : false},
                    // uploadUrl : "#",
                    // uploadExtraData : _ => {},
                    // deleteUrl : "#",
                    // deleteExtraData : _ => {},
                });





                // $("#frmEditar .selectpicker").selectpicker("render");
                $("#modalEditar").modal("show");

            })
            .catch(errorCatch)



        });

        $(document).on("click",".btnModalVer",function(e){
            e.preventDefault();
            var idregistro = $(this).closest('div.dropdown-menu').data('idregistro');


            cargando('Procesando...');
            axios(URL_VER,{ params: {idregistro : idregistro} })
            .then(response => {
                const data = response.data;

                stop();

                $("#nombreShow").html(data.nombre);
                $("#contenidoShow").html(data.contenido);



                if(data.imagen){
                    const img = `<img src="${ URL_CARPETA+data.imagen }" style ="width: 200px;" >`;
                    $("#imagenShow").html(img);
                }

                if (data.estado){
                    $("#estadoShow").html('<label class="badge badge-success">Habilitado</label>');
                }else{
                    $("#estadoShow").html('<label class="badge badge-danger">Inhabilitado</label>');
                }


                $("#modalVer").modal("show");

            })
            .catch(errorCatch)


        });

    }

    const guardar = () => {
        $(document).on("submit","#frmCrear",function(e){
            e.preventDefault();
            var form = new FormData($(this)[0]);
            form.append('contenido',CKEDITOR.instances.contenido.getData());

            cargando('Procesando...');
            axios.post(URL_GUARDAR,form)
            .then(response => {
                const data = response.data;
                stop();

                $("#modalCrear").modal("hide");
                notificacion("success","Registro exitoso",data.mensaje);
                listado();

            })
            .catch(errorCatch)




        });
    }

    const modificar = () => {
        $(document).on("submit","#frmEditar",function(e){
            e.preventDefault();

            var form = new FormData($(this)[0]);
            form.append('contenidoEditar',CKEDITOR.instances.contenidoEditar.getData());

            cargando('Procesando...');
            axios.post(URL_MODIFICAR,form)
            .then(response => {
                const data = response.data;

                stop();
                $("#modalEditar").modal("hide");
                notificacion("success","Modificación exitosa",data.mensaje);
                listado($("#cantidadRegistros").val(),$("#paginaActual").val());

            })
            .catch(errorCatch)


        });
    }

    const habilitar = () => {
        $(document).on( "submit" ,"#frmHabilitar", function(e){
            e.preventDefault();
            var form = new FormData($(this)[0]);
            cargando('Procesando...');

            axios.post(URL_HABILITAR,form)
            .then( response => {
                const data = response.data;
                stop();

                $("#modalHabilitar").modal("hide");

                notificacion("success","Habilitado",data.mensaje);

                listado($("#cantidadRegistros").val(),$("#paginaActual").val());

            })
            .catch( errorCatch )


        } )

    }

    const inhabilitar = () => {
        $(document).on( "submit","#frmInhabilitar" , function(e){
            e.preventDefault();

            var form = new FormData($(this)[0]);

            cargando('Procesando...');

            axios.post(URL_INHABILITAR,form)
            .then( response => {
                const data = response.data;
                stop();
                $("#modalInhabilitar").modal("hide");

                notificacion("success","Inhabilitado",data.mensaje);

                listado($("#cantidadRegistros").val(),$("#paginaActual").val());

            } )
            .catch( errorCatch )

        } )
    }

    const eliminar = () => {
        $(document).on( "submit","#frmEliminar" , function(e){
            e.preventDefault();

            var form = new FormData($(this)[0]);

            cargando('Procesando...');

            axios.post(URL_ELIMINAR,form)
            .then( response => {
                const data = response.data;
                stop();
                $("#modalEliminar").modal("hide");

                notificacion("success","Eliminado",data.mensaje);

                listado($("#cantidadRegistros").val(),$("#paginaActual").val());

            } )
            .catch( errorCatch )

        } )
    }


        const errorCatch = ( error ) => {

        const response = error.response;
        const data = response.data;

   

        if (response.status == 500){
            toastr.error("Error del servidor, contácte con soporte.");
        }

        if (response.status == 400){
            mensaje = data.mensaje
            toastr.error(mensaje);

        }

        console.log(data);
        return false;


    }

        const getPositions = (accion,valorActual = null) => {

        const id = accion == 'editar' ? '#posicionEditar' : '#posicion';
        const elemento  = document.querySelector(id);

        axios({
            url : URL_POSICIONES,
            method : 'get',
        })
        .then(response => {
            const data = response.data;
            const total = data.total;

            const valorFinal = valorActual == null ? total : valorActual;

            elemento.innerHTML = '';
            for (let i = 1; i <= total; i++) {
                const option = document.createElement('option');
                option.value = i;
                option.innerHTML = i;

                if(i == valorFinal){
                    option.selected = true;
                }

                elemento.appendChild(option);
            }
        
        })
        .catch(errorCatch)
        

    }

    const cargando = () => {

        $('body').waitMe({
            effect : 'bounce',
            text : '',
            bg : 'rgba(255,255,255,0.7)',
            color : '#000',
            maxSize : '',
            waitTime : -1,
            textPos : 'vertical',
            fontSize : '',
            source : '',
            onClose : function() {}
        });

    }

    const stop = () => {

        $("body").waitMe("hide");
    }

    const configCkeditor = {
        filebrowserBrowseUrl : '../ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl : '../ckfinder/ckfinder.html?type=Images',
        filebrowserFlashBrowseUrl : '../ckfinder/ckfinder.html?type=Flash',
        filebrowserUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
        filebrowserImageUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
        filebrowserFlashUploadUrl : '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
    };
    

    const configFileImput = {
        theme                 : 'fa',
        language              : 'es',
        uploadAsync           : false,
        showUpload            : false,
        showRemove            : false,
        allowedFileTypes      : ["image"],
        // allowedFileExtensions : ['jpg', 'png', 'jpeg','gif','webp','tiff','tif','svg','bmp','mp4',
        overwriteInitial      : false,
        initialPreviewAsData  : true,
        removeFromPreviewOnError  : true,
        // fileActionSettings    : { showRemove  : false, showUpload  : false, showZoom    : true, showDrag    : false},
        // dropZoneEnabled:false,
    }

    $("#imagen").fileinput({
        dropZoneTitle : 'Arrastre la imagen aquí',
        fileActionSettings    : { showRemove  : false, showUpload  : false, showZoom    : true, showDrag    : false},
        ...configFileImput,
        // uploadUrl            : "URL de subida",
        // uploadExtraData      : false,
        // deleteUrl            : "URL de eliminacion",
        // deleteExtraData      : false,
    });
    $("#imagenEditar").fileinput({
        dropZoneTitle : 'Arrastre la imagen aquí',
        fileActionSettings    : { showRemove  : false, showUpload  : false, showZoom    : true, showDrag    : false},
        ...configFileImput,
        // uploadUrl            : "URL de subida",
        // uploadExtraData      : false,
        // deleteUrl            : "URL de eliminacion",
        // deleteExtraData      : false,
    });





    $(function () {
        modales();
        filtros();
        guardar();
        modificar();
        habilitar();
        inhabilitar();

        CKEDITOR.replace('contenido',{ height : 200 });
        CKEDITOR.replace('contenidoEditar',{ height : 200 });

    });


</script>


</body>
</html>