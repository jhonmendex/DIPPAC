<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 20px;min-width: 660px">    
    <fieldset class="colorleyend" style="width: 650px;">
        <legend class="colorleyendinto">Lista de proveedores</legend>   
        <p style="margin-bottom: 20px; margin-top: 0 !important">Seleccione uno de los proveedores de la lista haciendo click en el nombre o cree uno nuevo.</p>
            <a style="cursor: pointer; color: #005500; font-weight: bold; margin-bottom: 10px" 
               id="create" href="#">
                + Crear nuevo proveedor
            </a>         
        <div style="margin-top: 15px">
            <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">      
                <thead>
                    <tr class="headall">     
                        <th class="headinit">Nombre del proveedor</th>                        
                        <th class="head">Nit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($proveedores) != 0) {
                        foreach ($proveedores as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>"> 
                                <td class="init2">
                                    <a class="selectitem" href="#" id="<?php echo $value["id"] ?>">
                                        <?php echo $value["nombre"] ?>
                                    </a>
                                </td>  
                                <td class="item2" id="nit<?php echo $value["id"] ?>">
                                    <?php echo $value["nit"] ?>
                                </td>                                                        
                            </tr>
                            <?php
                            if ($estilo == 1) {
                                $estilo = 2;
                            } else {
                                $estilo = 1;
                            }
                        }
                    }
                    ?> 
                </tbody>
            </table>
        </div>
    </fieldset>
</div> 
<script>
    $(".selectitem").click(function() {
        $.ajax({
            type: "POST",
            url: "index.php?controlador=SupplierBuy&accion=verifyExistSupplier",
            dataType: "json",
            data: {nit_supplier: $.trim($("#nit" + $(this).attr("id")).html())},
            success: function(data) {
                parent.actualizarproveedor(data.nombre, "Nit. " + data.nit, data.id);
                parent.$.fancybox.close();
            }
        });

    });

    $(document).ready(function() {
        $("#create").click(function() {
            parent.crearproveedor()
            parent.$.fancybox.close();
        });
        $('img').css("border", "0");
        oTable = $('#mytable').dataTable({
            "aLengthMenu": [
                [10, 15, 20, -1],
                [10, 15, 20, "Todos"]
            ],
            "iDisplayLength": 10,
            "oLanguage": {
                "sEmptyTable": "No existen datos disponibles",
                "sInfo": "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando desde 0 hasta 0 de 0 registros",
                "sInfoFiltered": "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing": "Procesando...",
                "sSearch": "Buscar:",
                "sZeroRecords": "No se encontraron resultados",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": activar para Ordenar Ascendentemente",
                    "sSortDescending": ": activar para Ordendar Descendentemente"
                }
            },
            "sPaginationType": "full_numbers",
            "aaSorting": [[0, "asc"]],
            "aoColumns": [
                null,
                null,
            ]
        });
    });
</script>
