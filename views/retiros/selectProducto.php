<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container" style="margin-bottom: 20px; margin-top: 10px;min-width: 780px">  
    <div style="float: left;width: 95%;">
        <fieldset class="colorleyend" style="width: 100%;">
            <legend class="colorleyendinto">Opciones</legend>
            <form method="POST" action="index.php?controlador=Retiros&accion=getProducts">
                <div id="cajaselect" style="margin-bottom: 15px">
                    Seleccione categoria:
                    <select id="categorias" name="idcat">
                        <?php                
                if(sizeof($categorias)==0){?>
                        <option value="9999999">NO EXISTEN CATEGORIAS DISPONIBLES</option>
                        <?php 
                }else{
                        foreach ($categorias as $key => $value) { ?>
                            <option value="<?php echo $key ?>">
                                <?php echo $value ?>
                            </option>

                        <?php }?>
                        <option value="all">TODAS LAS CATEGORIAS</option>
                        <?php } ?>
                            
                    </select>                    
                    <button class="buscarButton" id="ordernow">ACEPTAR</button>   
                </div>
            </form>
        </fieldset>
    </div>
    <div style="clear: left"></div>
     <fieldset class="colorleyend" style="width: 95%;">
            <legend class="colorleyendinto">
                Lista de productos<?php echo sizeof($categorias)==0?"":$categoriaselected=="all"?" de TODAS LAS CATEGORIAS":" de ".$categorias[$categoriaselected]?>
            </legend>
             <p style="margin-bottom: 20px; margin-top: 0 !important">Seleccione uno de los producto de la lista haciendo click en el nombre.</p>
    <div style="margin-top: 15px;margin-bottom: 20px">
        <table class="table" border="0" cellspacing="0" cellpadding="0" id="example">    
            <thead>
                <tr class="headall">     
                    <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                    <th class="head">Referencia</th>                                    
                </tr> 
            </thead>
            <tbody>
                <?php
                $estilo = 1;
                if(sizeof($productos)!=0){
                foreach ($productos as $value) {
                    ?>
                    <tr class="class<?php echo $estilo; ?>"> 
                        <td class="init2" style="width: 450px;">
                            <a class="selectitem" href="#" id="<?php echo $value["id"] ?>">
                            <?php echo $value["nombre"] ?>
                            </a>
                        </td>  
                        <td class="item2" style="width: 40px;" id="refe<?php echo $value["id"] ?>">
                            <?php echo $value["referencia"] ?>
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
    $(document).ready(function(){  
        $(".selectitem").click(function(){                        
            $("#codeprod", window.parent.document).val($.trim($("#refe"+$(this).attr("id")).html()));            
            $('.error_input', window.parent.document).remove();
            parent.$.fancybox.close();
        });
        $('img').css("border","0");
        $('#categorias').val("<?php echo $categoriaselected; ?>");
        $('#example').dataTable({
            "oLanguage":  {
                "sEmptyTable":     "No existen datos disponibles",
                "sInfo":           "Mostrando desde _START_ hasta _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando desde 0 hasta 0 de 0 registros",
                "sInfoFiltered":   "(filtrado de _MAX_ registros en total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sLoadingRecords": "Cargando...",
                "sProcessing":     "Procesando...",
                "sSearch":         "Buscar:",
                "sZeroRecords":    "No se encontraron resultados",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": activar para Ordenar Ascendentemente",
                    "sSortDescending": ": activar para Ordendar Descendentemente"
                }
            },
            "sPaginationType": "full_numbers",
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                null,
                { "bSortable": false}
            ]					
        } );
    });
</script>
