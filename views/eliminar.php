
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog"  aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white"><i class="fa fa-exclamation-triangle"></i> Alerta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmEliminar" autocomplete="off">
                    <input type="hidden" name="idregistro" required>
                   
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <p>¿Esta seguro de <b class="text-danger">eliminar</b> este registro?</p>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right">
                            <hr>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Si, acepto</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>

                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

