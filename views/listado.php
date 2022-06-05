<?php if(count($registros) > 0): ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr class="text-center">
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>POSICIÓN</th>
                    <th>ESTADO</th>
                    <th>GESTIONAR</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach($registros AS $item): ?>

                    <tr>
                        <td><?= str_pad($item["idregistro"],7,'0000000',STR_PAD_LEFT) ?></td>
                        <td><?= $item["nombre"] ?></td>
                        <td><?= $item["posicion"] ?></td>
                        <td>
                            <?php if($item["estado"]) : ?>
                                <label class="badge badge-success">Habilitado</label>
                            <?php else : ?>
                                <label class="badge badge-danger">Inhabilitado</label>
                            <?php endif; ?>
                        </td>

                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu-<?=$item["idregistro"]?>" data-toggle="dropdown" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                    Seleccione
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu-<?=$item["idregistro"]?>" data-idregistro="<?=$item["idregistro"]?>">
                                    <button class="dropdown-item btnModalVer" type="button"><i class="fa fa-eye"></i> Ver</button>
                                    <button class="dropdown-item btnModalEditar" type="button"><i class="fa fa-pencil"></i> Editar</button>
                                    <?php if($item["estado"] == 1): ?>
                                        <button class="dropdown-item btnModalInhabilitar" type="button"><i class="fa fa-check"></i> Inhabilitar</button>
                                    <?php else: ?>
                                        <button class="dropdown-item btnModalHabilitar" type="button"><i class="fa fa-times"></i> Habilitar</button>
                                    <?php endif; ?>
                                    <button class="dropdown-item btnModalEliminar" type="button"><i class="fa fa-trash"> Eliminar</i></button>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                    
                <?php endforeach; ?>

            </tbody>
        </table>


        <p>
            <input type="hidden" name="paginaActual" id="paginaActual" value="<?php echo $pagination["paginaActual"]; ?>">
            Pagina <?=$pagination["paginaActual"]?> / <?=$pagination["ultimaPagina"]?>  de <?=$pagination["total"]?> registro(s)
        </p>
        <?php if($pagination["total"] > $pagination["cantidadRegistros"] ): ?>
            <div>
                <center>
                <nav>
                    <ul class="pagination">
                        <?php if($pagination["paginaActual"] > 1): ?>
                            <li  class="page-item">
                                <a class="page-link" href="listar?pagina=<?=$pagination['paginaActual'] - 1 ?>">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Atras</span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php foreach($pagination["paginas"] as $v): ?>
                            <li class="page-item <?=$v == $pagination["paginaActual"] ? 'active' : '' ?>" >
                                <a class="page-link"  href="listar?pagina=<?=$v ?>"  > <?=$v?> </a>
                            </li>
                        <?php endforeach; ?>

                        <?php if($pagination["paginaActual"] < $pagination["ultimaPagina"]): ?>
                            <li  class="page-item">
                                <a class="page-link" href="listar?pagina=<?=$pagination['paginaActual'] + 1 ?>">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                </center>
            </div>
        <?php endif; ?>

    </div>
<?php else: ?>
<div class="alert alert-danger">
    <p class="text-center mb-0"><i class="fa fa-exclamation-circle"></i> No hay registros encontrados para mostrar.</p>
</div>
<?php endif; ?>
























