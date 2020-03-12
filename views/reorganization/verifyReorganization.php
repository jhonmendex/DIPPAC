<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>   
<?php if ($_GET["tipo"] == rp) { ?>
    <div class="container">      
        <fieldset class="colorleyend" style="width: 95%;">  
            <legend class="colorleyendinto">Verificaci&oacute;n de datos de la reorganización del producto</legend> 
            <div id="cajaselect" style="margin-bottom: 15px">
                <table border="0" width="100%">
                    <tr>           
                        <td><div style="width: 100%; font-size: 15px; line-height: 17px ; color: #993300;  float: left">
                                <?php echo "Producto a reorganizar:"; ?> <strong><?php echo $items2["nombre"]; ?></strong></div></td>
                        <td align="center" rowspan="2">                                 
                        </td>        
                        <td align="center" rowspan="2">                            
                        </td> 
                    </tr> 
                    <tr>           
                        <td><div style="width: 100%; font-size: 15px; line-height: 17px ; color: #993300;  float: left">
                                <?php echo "Cantidad a retirar del producto:"; ?> <strong><?php echo $items2["cantidad"]; ?></strong></div></td>
                        <td align="center" rowspan="2">                             
                        </td>        
                        <td align="center" rowspan="2">                       
                        </td> 
                    </tr>
                </table> 
            </div>      
            <div>      
                <table class="table"  width="100%" border="1" cellspacing="0" cellpadding="0" id="example2" > 
                    <thead>  
                        <tr class="headall"> 
                            <th class="headinit" style="cursor: pointer; width: 15%">Referencia</th>
                            <th class="head" style="cursor: pointer; width: 30%">Articulo</th>                 
                            <th class="head" style="cursor: pointer; width: 15%">Cantidad de productos a reorganizar</th>
                        </tr>   
                    </thead>  
                    <tbody>  
                        <?php
                        $estilo = 1;
                        if ($items) {
                            foreach ($items as $value) {
                                ?>   
                                <tr class="class<?php echo $estilo; ?>" id="<?php echo $value['id']; ?>">                     
                                    <td align="left" class="init2" id="nameb<?php echo $value["id"] ?>">
                                        <?php echo $value["referencia"] ?>    
                                    </td>     
                                    <td align="left" class="item2" id="art<?php echo $value["iddetalle"] ?>">
                                        <?php echo $value["nombre"] ?>
                                    </td>                 
                                    <td align="center" class="item2" id="nameb<?php echo $value["id"] ?>">   
                                        <input name="cantidadreo"
                                               label="cantidadreo"  
                                               size="7"
                                               maxlength="5" 
                                               value="<?php echo $value["cantid"] ?>"
                                               disabled="disabled"/>                                   
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
        <div style="float: left;height: 40px">          
        <a onclick="finrepro()">        
            <button style="height: 40px" class="buscarButton" id="siguiente">     
                Finalizar 
            </button>
        </a>     
    </div>       
    <div style="float: left;height: 40px; margin-left: 5px">            
        <a href="index.php?controlador=Reorganization&accion=reorganizarProducto">   
            <button style="height: 40px" class="buscarButton" id="Back">Atrás</button>
        </a>                      
    </div>      
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
    </div>   
<?php } else { ?> 
    <div class="container">       
        <fieldset class="colorleyend" style="width: 90%;">  
            <legend class="colorleyendinto">Verificar reorganización de varios productos</legend> 
            <div id="cajaselect" style="margin-bottom: 15px">
                <table border="0" width="100%">
                    <tr>           
                        <td><div style="width: 100%; font-size: 15px; line-height: 17px ; color: #993300;  float: left">
                                <?php echo "Producto a ingresar en la reorganizaci&oacute;n:"; ?> <strong><?php echo $items4["nombre"]; ?></strong></div></td>
                        <td align="center" rowspan="2">                                 
                        </td>        
                        <td align="center" rowspan="2">                            
                        </td> 
                    </tr> 
                    <tr>           
                        <td><div style="width: 100%; font-size: 15px; line-height: 17px ; color: #993300;  float: left">
                                <?php echo "Cantidad a ingresar del producto:"; ?> <strong><?php echo $items4["cantidad"]; ?></strong></div></td>
                        <td align="center" rowspan="2">                             
                        </td>        
                        <td align="center" rowspan="2">                       
                        </td> 
                    </tr>
                </table> 
            </div>             
            <div>      
                <table class="table"  width="100%" border="1" cellspacing="0" cellpadding="0" id="example2" > 
                    <thead>  
                        <tr class="headall"> 
                            <th class="headinit" style="cursor: pointer; width: 15%">Referencia</th>
                            <th class="head" style="cursor: pointer; width: 30%">Articulo</th>                 
                            <th class="head" style="cursor: pointer; width: 15%">Cantidad de productos a reorganizar</th>
                        </tr>   
                    </thead>  
                    <tbody>  
                        <?php
                        $estilo = 1;
                        if ($items3) {
                            foreach ($items3 as $value) {
                                ?>   
                                <tr class="class<?php echo $estilo; ?>" id="<?php echo $value['id']; ?>">                     
                                    <td align="left" class="init2" id="nameb<?php echo $value["id"] ?>">
                                        <?php echo $value["referencia"] ?>    
                                    </td>     
                                    <td align="left" class="item2" id="art<?php echo $value["iddetalle"] ?>">
                                        <?php echo $value["nombre"] ?>
                                    </td>                 
                                    <td align="center" class="item2" id="nameb<?php echo $value["id"] ?>">   
                                        <input name="cantidadreo"
                                               label="cantidadreo"  
                                               size="7"
                                               maxlength="5" 
                                               value="<?php echo $value["cantid"] ?>"
                                               disabled="disabled"/>                                   
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
         <div style="float: left;height: 40px">          
        <a onclick="finrepros()">        
            <button style="height: 40px" class="buscarButton" id="siguiente">     
                Finalizar 
            </button>
        </a>     
    </div>       
    <div style="float: left;height: 40px; margin-left: 5px">            
        <a href="index.php?controlador=Reorganization&accion=reorganizarProductos">   
            <button style="height: 40px" class="buscarButton" id="Back">Atrás</button>
        </a>                      
    </div>      
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>       
    </div>  
<?php } ?> 
<script>        
     function finrepro(){
         window.location="index.php?controlador=Reorganization&accion=finalizarReorganizacionp";
     }
     
     function finrepros(){
         window.location="index.php?controlador=Reorganization&accion=finalizarReorganizacionps";
     }
    
    jQuery.fn.dataTableExt.oSort['numeric-comma-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ? -1 : ((x > y) ?  1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['numeric-comma-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( /,/, "." );
        var y = (b == "-") ? 0 : b.replace( /,/, "." );
        x = parseFloat( x );
        y = parseFloat( y );
        return ((x < y) ?  1 : ((x > y) ? -1 : 0));
    };

    jQuery.fn.dataTableExt.oSort['numeric-point-asc']  = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "$", "" ).replace( ".", "" );
        var y = (b == "-") ? 0 : b.replace( "$", "" ).replace( ".", "" );
        return (x-y);
    };

    jQuery.fn.dataTableExt.oSort['numeric-point-desc'] = function(a,b) {
        var x = (a == "-") ? 0 : a.replace( "$", "" ).replace( ".", "" );
        var y = (b == "-") ? 0 : b.replace( "$", "" ).replace( ".", "" );
        return (y-x);
    }; 
    $(document).ready(function(){ 
    
        oTable=$('#example2').dataTable( {
            "fnCreatedRow": function( nRow, aData, iDataIndex ) { 
                $(nRow).addClass("class1");
                $('td:eq(0)', nRow).addClass('init2');
                $('td:eq(1)', nRow).addClass('item2');
                $('td:eq(2)', nRow).addClass('item2');
                $('td:eq(3)', nRow).addClass('item2');
                if($('td:eq(3) input', nRow).attr('objectid')){                    
                    $('td:eq(3)', nRow).css('text-align','center'); 
                    $('td:eq(2)', nRow).css('text-align','center');
                }
            }, 
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
            "aaSorting": [[ 1, "asc" ]],
            "aoColumns": [ 
                null,    
                null,
                { "bSortable": false, "bSearchable": false } 
            ] 
        } );        
    });
</script>
