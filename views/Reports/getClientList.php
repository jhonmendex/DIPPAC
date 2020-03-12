<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 20px;min-width: 660px">    
    <fieldset class="colorleyend" style="width: 650px;">
        <legend class="colorleyendinto">Lista de Clientes</legend>   
        <p style="margin-bottom: 20px; margin-top: 0 !important">Seleccione uno de los clientes de la lista haciendo click en el nombre.</p>                    
        <div style="margin-top: 15px">
            <table class="table" border="0" cellspacing="0" cellpadding="3" id="mytable">      
                <thead>
                    <tr class="headall">     
                        <th class="headinit">Nombre del cliente</th>                        
                        <th class="head">Cedula</th>
                        <th class="head">Codigo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $estilo = 1;
                    if (sizeof($clientes) != 0) {
                        foreach ($clientes as $value) {
                            ?>
                            <tr class="class<?php echo $estilo; ?>"> 
                                <td class="init2">
                                    <a class="selectitem" href="#" id="<?php echo $value["codigo"] ?>" nombre="<?php echo $value["nombre"] ?>" cedula="<?php echo $value["cedula"] ?>">
                                        <?php echo $value["nombre"] ?>
                                    </a>
                                </td>  
                                <td class="item2" id="nit<?php echo $value["codigo"] ?>">
                                    <?php echo $value["cedula"] ?>
                                </td>     
                                <td class="item2" id="nit<?php echo $value["codigo"] ?>">
                                    <?php echo $value["codigo"] ?>
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

    $(document).ready(function() {       
        $(".selectitem").click(function() {            
            $.ajax({
                type: "POST", 
                url: "index.php?controlador=Reports&accion=AddToPos",
                dataType: "json",
                data: {id_cliente: $.trim($(this).attr("id")), cedula_cliente: $.trim($(this).attr("cedula")), nombre_cliente: $.trim($(this).attr("nombre"))},
                success: function(data) {
                    parent.actualizarcliente(data.id,data.nombre);
                    parent.$.fancybox.close();
                }
            });

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
                null
            ]
        });
    });
</script>
