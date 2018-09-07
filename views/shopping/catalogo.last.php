<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<script type="text/javascript">
    var chequeados={};
    function addCheck(nameCheck){              
        if($('input[name='+nameCheck+']').is(':checked')){ 
            var $inputt = $('#form'+nameCheck+' :input');   
            $inputt.each(function() {                                                          
                if($(this).attr('name')=='cantidad'){                                          
                    var res=presence($(this).val());
                    if(res=='ok'){ 
                        $('.error_input').remove(); 
                        chequeados[nameCheck]=$(this).val();
                    } else{
                        $('.error_input').remove();  
                        $('input[name='+nameCheck+']').attr('checked', false);
                        $(this).after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">'+res+'</div>');                                                             
                        message('Debe ingresar una cantidad','images/iconos_alerta/error.png');
                    }
                }
            });
        }else{
            var $inputt = $('#form'+nameCheck+' :input');   
            $inputt.each(function() {                                                          
                if($(this).attr('name')=='cantidad'){                                          
                    $('.error_input').remove();  
                    $(this).val('');
                    delete chequeados[nameCheck];                                                
                }
            }); 
        }                  
    }    
    $(document).ready(function() {        
        $("#categorias").change(function() {            
            window.location='index.php?controlador=Shopping&pag=1&cat='+$('#categorias').val();
        });   
        
        $('#shopall').click(function(){ 
            var contador=0;
            for(var i in chequeados){
                contador++;
            }            
            if(contador>0){                            
                var values={items: chequeados};            
                $.ajax({                
                    type: "POST",
                    async:false,
                    dataType: "json",               
                    url: "index.php?controlador=Shopping&accion=itemsVarious",
                    data: values,
                    success: function( response ) 
                    {        
                        window.location='index.php?controlador=Shopping&accion=orden&idcategoria=<?php echo $categoriaactual ?>&paginaact=<?php echo $page ?>';
                    },
                    error: function( error ){
                        alert( error );
                    }
                });
            }else{
                message('Debe seleccionar al menos un producto','images/iconos_alerta/error.png');
            }
        });
        
        $('#shopall2').click(function(){                                       
            var contador=0;
            for(var i in chequeados){
                contador++;
            }            
            if(contador>0){                            
                var values={items: chequeados};            
                $.ajax({                
                    type: "POST",
                    async:false,
                    dataType: "json",               
                    url: "index.php?controlador=Shopping&accion=itemsVarious",
                    data: values,
                    success: function( response ) 
                    {        
                        window.location='index.php?controlador=Shopping&accion=orden&idcategoria=<?php echo $categoriaactual ?>&paginaact=<?php echo $page ?>';
                    },
                    error: function( error ){
                        alert( error );
                    }
                });
            }else{
                message('Debe seleccionar al menos un producto','images/iconos_alerta/error.png');
            }
        });          
    });                                       
</script>
<div style="display: block;" id="flotante">
    <div id="cajaselect">
        Seleccione categoria:
        <select id="categorias">
            <?php foreach ($categorias as $key => $value) {
                if ($key == $categoriaactual) { ?>
                    <option value="<?php echo $key ?>" selected="true">
                        <?php echo $value ?>
                    </option>
                <?php } else { ?>  
                    <option value="<?php echo $key ?>">
                        <?php echo $value ?>
                    </option>
                <?php }
            } ?>
        </select>       
    </div>
    <div id="cajaselect">
        <form method="get" action="index.php" onsubmit="return validates($(this).attr('id'))" id="buscadornombre">
            <div style="float: left;">
                Buscar:
            </div>
            <div style="float: left; margin-left: 10px">
                <input type="text" id="nomProducto" name="nomProducto" presence="val1" label="Nombre del producto" maxlength="40" autocomplete="off"/>            
            </div>
            <input type="hidden" name="controlador" value="Shopping"/>
            <input type="hidden" name="accion" value="resultado"/>
            <input type="hidden" name="pag" value="1"/>
            <input type="hidden" name="idcategoria" value="<?php echo $categoriaactual ?>"/>
            <div style="float: left; margin-left: 10px">
                <button class="buscarButton">Buscar</button>
            </div>
            <div style="clear: both;">
            </div>
        </form>
    </div>
</div>
<div class="carrito" id="carrito">

    <div class="contenido">        
        <div style=";margin-bottom: 24px;  color: #009900; font-weight: bold">Agregar al carrito todos los elementos seleccionados: <button id="shopall" class="buscarButton">comprar</button></div>
        <table>
            <tr>
                <th><?php echo $productos[0]; ?> 

                </th>
                <th><?php echo $productos[1]; ?> 

                </th>
                <th><?php echo $productos[2]; ?> 

                </th>
            </tr>
            <tr>
                <th><?php echo $productos[3]; ?> 

                </th>
                <th><?php echo $productos[4]; ?> 

                </th>
                <th><?php echo $productos[5]; ?> 

                </th>
            </tr>
            <tr>
                <th><?php echo $productos[6]; ?> 

                </th>
                <th><?php echo $productos[7]; ?> 

                </th>
                <th><?php echo $productos[8]; ?> 

                </th>
            </tr>
            <tr>
                <th><?php echo $productos[9]; ?> 

                </th>
                <th><?php echo $productos[10]; ?> 

                </th>
                <th><?php echo $productos[11]; ?> 

                </th>
            </tr>
            <tr>
                <th><?php echo $productos[12]; ?> 

                </th>
                <th><?php echo $productos[13]; ?> 

                </th>
                <th><?php echo $productos[14]; ?> 

                </th>
            </tr>
        </table>          
        <div style="clear: both;margin-top: 12px;margin-bottom: 24px; color: #009900; font-weight: bold">Agregar al carrito todos los elementos seleccionados: <button id="shopall2" class="buscarButton">comprar</button></div>

        <?php echo $paginacion ?>        
    </div> 

</div>