<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>             
<div class="container">         
    <fieldset class="colorleyend" style="width: 95%; margin-top: 5px">     
        <legend class="colorleyendinto">Paso 1: Selección de los productos a reorganizar</legend>     
        <div id="cajaselect" style="margin-bottom: 5px">
            <table border="0" width="100%">                                 
                <tr>     
                    <td>Seleccione categoria:
                        <select id="categorias" name="idcat">
                            <?php foreach ($categorias as $key => $value) { ?>
                                <option value="<?php echo $key ?>">
                                    <?php echo $value ?>
                                </option>       
                            <?php } ?>  
                        </select>                             
                    </td>                   
                </tr>
            </table> 
        </div>  
        <div style="margin-top: 0px;margin-bottom: 20px">     
            <table class="table" cellspacing="0" cellpadding="0" id="example">    
                <thead>       
                    <tr class="headall">      
                        <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                        <th class="head">Referencia</th> 
                        <th class="head">Stock</th>  
                        <th class="head" style="cursor: pointer;">Cantidad</th>
                        <th class="head" style="cursor: pointer;">Costo</th>  
                        <th class="head">Agregar</th>                     
                    </tr>    
                </thead>        
                <tbody> 
                    <?php
                    $estilo = 1;
                    if(sizeof($detalles[0])!=0){
                    foreach ($detalles[0] as $value) {
                        ?>      
                        <tr class="class<?php echo $estilo; ?>" id="none<?php echo $value["id"] ?>">  
                            <td class="init2" style="width: 450px;" id="nome"> 
                                <?php echo $value["nombre"] ?>
                            </td>    
                            <td class="item2" style="width: 40px;" id="ref2<?php echo $value["id"] ?>">
                                <?php echo $value["referencia"] ?>
                            </td>  
                            <td class="item2" style="width: 10px;text-align: center;" id="st<?php echo $value["id"] ?>">
                                <?php
                                $view->input("stock", "numeric", "stock", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                    'maxlength' => '5',
                                    "id" => "stock" . $value["id"],
                                    "item" => $value["id"],
                                    "disabled" => "disabled",
                                    "style" => 'background-color:#C9D3E8',
                                    "value" => $value["stock"]));
                                ?>           
                            </td>                           
                            <td class="item2" style="width: 40px;;text-align: center" id="price<?php echo $value["id"] ?>">
                                <?php
                                if ($value['unidad'] == 'und') {
                                    if (isset($_SESSION['Reorgsesionps'][$value["id"]])) {
                                        $view->input("cantdev", "numeric", "cantidad devolucion", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                            'maxlength' => '5',
                                            "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                            "id" => "cantdev" . $value["id"],
                                            "item" => $value["id"],
                                            "style" => 'background-color:#fff',
                                            "value" => $_SESSION['Reorgsesionps'][$value["id"]]["cantid"]));
                                    } else {
                                        $view->input("cantdev", "numeric", "cantidad devolucion", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                            'maxlength' => '5',
                                            "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                            "id" => "cantdev" . $value["id"],
                                            "item" => $value["id"],
                                            "value" => ""));
                                    }
                                } else {
                                    if (isset($_SESSION['Reorgsesionps'][$value["id"]])) {
                                        $view->input("cantdev", "text", "cantidad devolucion", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('size' => '5',
                                            'maxlength' => '5',
                                            "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                            "id" => "cantdev" . $value["id"],
                                            "item" => $value["id"],
                                            "value" => $_SESSION['Reorgsesionps'][$value["id"]]["cantid"]));
                                    } else {
                                        $view->input("cantdev", "text", "cantidad devolucion", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('size' => '5',
                                            'maxlength' => '5',
                                            "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                            "id" => "cantdev" . $value["id"],
                                            "item" => $value["id"],
                                            "value" => ""));
                                    }
                                }
                                ?>              
                            </td>  
                            <td class="item2" style="width: 10px;text-align: center;" id="pricefull<?php echo $value["id"] ?>">
                                <?php echo '&#36;' . number_format($value["costo"], 0, ',', '.'); ?>                                   
                            </td>                 
                            <td class="item2" style="width: 20px;text-align: center"> 
                                <?php if (isset($_SESSION['Reorgsesionps'][$value["id"]])) {
                                    if ($_SESSION['Reorgsesionps'][$value["id"]]["estado"] == 'Remover') { ?>
                                        <button style="background-color: #ff4040 " item ="<?php echo $value["id"] ?>" class="buscarButton" id="agregarpr<?php echo $value["id"] ?>" idck="<?php echo $value["id"] ?>"  onclick="seleccionar($(this).attr('id'),$(this).attr('item'))" > <?php echo $_SESSION['Reorgsesionps'][$value["id"]]["estado"]; ?></button>      
                                    <?php } else { ?>
                                        <button item ="<?php echo $value["id"] ?>" class="buscarButtonDis" id="agregarpr<?php echo $value["id"] ?>" idck="<?php echo $value["id"] ?>" disabled="disabled"  onclick="seleccionar($(this).attr('id'),$(this).attr('item'))" > <?php echo $_SESSION['Reorgsesionps'][$value["id"]]["estado"]; ?></button>      
                                    <?php } ?>                                          
                                <?php } else { ?>
                                    <button item ="<?php echo $value["id"] ?>" class="buscarButtonDis" id="agregarpr<?php echo $value["id"] ?>" idck="<?php echo $value["id"] ?>" disabled="disabled"  onclick="seleccionar($(this).attr('id'),$(this).attr('item'))" >Agregar</button> 
                                <?php } ?>                               
                            </td>                             
                        </tr>   
                        <?php
                        if ($estilo == 1) {
                            $estilo = 2;
                        } else {
                            $estilo = 1;
                        }
                    }}                    
                    ?>
                </tbody>
            </table> 
        </div>            
    </fieldset>             
    <fieldset class="colorleyend" style="width: 95%;">  
        <legend class="colorleyendinto">Paso 2: Selección del producto</legend> 
        <div id="inputreferencia">
            <div style="line-height: 20px; width: 500px; margin-bottom: 12px"> 
                Ingrese el producto en el que quiere clasificar  de los anteriores productos :  
            </div>
            <div style="margin-left: 15px; float: left; margin-bottom: 20px">
                <input type="text" name="codigopro" id="codeprod" maxlength="15" size="30"/>                
            </div>    
            <div style="margin-left: 2px;float: left; margin-top: 2px; margin-bottom: 20px">
                <a id="search" href="index.php?controlador=Retiros&accion=getProducts" title="Buscar producto">
                    <img src="images/zoom.png" width="17" height="17"/>
                </a>
            </div> 
            <div style="margin-left: 10px;float: left; margin-bottom: 20px">
                <button class="buscarButton" id="addToOut">Agregar</button>  
            </div>
            <div style="clear: both;"></div>
        </div>   
        <div style="clear: left"></div>
        <div>  
            <form id="areorgn" method="post" action="">
            <table class="table"  width="100%" border="1" cellspacing="0" cellpadding="0" id="example2" > 
                <thead> 
                    <tr class="headall"> 
                        <th class="headinit" style="cursor: pointer; width: 10%">Referencia</th>
                        <th class="head" style="cursor: pointer; width: 30%">Articulo</th>                 
                        <th class="head" style="cursor: pointer; width: 5%">Stock</th> 
                        <th class="head" style="cursor: pointer; width: 20%">Cuantos productos quiere reorganizar ?</th>
                        <th class="head" style="cursor: pointer; width: 5%">Remover producto</th>
                    </tr>  
                </thead> 
                <tbody id="tbodyex"> 
                    <?php
                    $estilo = 1;
                    if (sizeof($items)!=0){
                        foreach ($items as $value) {
                            ?> 
                            <tr class="class<?php echo $estilo; ?>" id="<?php echo $value['id']; ?>">                     
                                <td align="left" class="init2" id="ref1<?php echo $value["id"] ?>">
                                    <?php echo $value["referencia"] ?>    
                                </td>         
                                <td align="left" class="item2" id="nombrep">  
                                    <?php echo $value["nombre"] ?>
                                </td>  
                                <td align="center" class="item2" id="nameb<?php echo $value["id"] ?>">
                                    <?php echo $value["stock"] ?>    
                                </td>                 
                                <td align="center" class="item2" id="nameb<?php echo $value["id"] ?>"> 
                                    <?php
                                        if ($value['unidad'] == 'und') {
                                            $view->input("cantidad", "numeric", "cantidad", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('maxlength' => '3',
                                                "size" => "7",
                                                "id" => "cantreorg",
                                                "onkeyup" => "guardarcant()",
                                                "item" => $value["id"],
                                                "class" => "evento",
                                                "value" => isset($_SESSION['cantsesionps']) ? $_SESSION['cantsesionps'] : null));
                                        } else {
                                            $view->input("cantidad", "text", "cantidad", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('maxlength' => '6',
                                                "size" => "7",
                                                "id" => "cantreorg",
                                                "onkeyup" => "guardarcant()",
                                                "item" => $value["id"],
                                                "class" => "evento",
                                                "value" => isset($_SESSION['cantsesionps']) ? $_SESSION['cantsesionps'] : null));
                                        }
                                        ?>                                    
                                </td>     
                                <td align="center" class="item2" id="nameb<?php echo $value["id"] ?>">   
                                    <a id="dell<?php echo sha1($value['id']); ?>"  
                                       callback="<?php echo $value['nombre']; ?>"       
                                       tar="index.php?controlador=Reorganization&accion=deleteItempps" 
                                       verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                       href="#"         
                                       onclick="confirmfunction($(this).attr('id'))">
                                        <img class="delete" src="images/delete.gif" title="Eliminar item"/> 
                                    </a>                                         
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
        </form>
        </div>    
    </fieldset>  
    <div style="float: left;height: 40px">          
        <a onclick="siguiente()">        
            <button style="height: 40px" class="buscarButton" id="siguiente">     
                Siguiente 
            </button>
        </a>     
    </div>
    <div style="float: left;height: 40px; margin-left: 5px">      
        <a id="allcancel"  
           tar="index.php?controlador=Reorganization&accion=cancelarsesionps" 
           href="#"       
           onclick="cancelarsesion($(this).attr('id'))">    
            <button style="height: 40px" class="buscarButton" id="CancelAll">Cancelar</button>
        </a>                      
    </div>      
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
</div> 
<div style="display: none"> 
    <div id="contentcall">        
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de cancelar la reorganizacion del producto? 
        </div>    
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel">CANCELAR</button>
        </div>
    </div> 
</div> 
<div style="display: none">   
    <div id="contentcall2">        
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de eliminar el item de la reorganizacion del producto <strong id="nombrep4"></strong>? 
        </div>     
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>      
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div> 
</div>    
<div style="display: none">    
    <a href="#contentcall" class="callback">Open Example</a>
    <a href="#contentcall2" class="callback2">Open Example</a>
</div> 
<script>  
    var oTable;
    function guardarcant(){   
        $.ajax({      
            type: "POST",                            
            url: 'index.php?controlador=Reorganization&accion=guardarCantps',
            dataType: "json",                      
            data: {cajas:($("#areorgn input[name='cantidad']").val())}                  
        });                          
    }      
            
    function siguiente(){  
        $('#loader').css('display', 'block');
        $("#siguiente").attr("disabled", "disabled");
        $("#siguiente").addClass("buscarButtonDis");
        $("#siguiente").removeClass("buscarButton");
        $("#CancelAll").attr("disabled", "disabled");
        $("#CancelAll").addClass("buscarButtonDis");
        $("#CancelAll").removeClass("buscarButton");
        if($(".dataTables_empty").val()==''){                         
            parent.message("Debe agregar el producto del paso 2 para poder continuar","images/iconos_alerta/error.png");            
            $('#loader').css('display', 'none');
            $("#siguiente").removeAttr("disabled");
            $("#siguiente").addClass("buscarButton");
            $("#siguiente").removeClass("buscarButtonDis");
            $("#CancelAll").removeAttr("disabled");
            $("#CancelAll").addClass("buscarButton");
            $("#CancelAll").removeClass("buscarButtonDis");
        }else{   
            if(validates("areorgn","no")){
                var mensajeres= true;
                var textodelmen;
                $.ajax({
                    type: "POST",
                    url: "index.php?controlador=Reorganization&accion=verifysessionps",
                    dataType: "json",
                    async: false,
                    success: function(data){ 
                        textodelmen=data.error;
                        if(data.res=='si'){                                
                            mensajeres= true;
                        }else{
                            mensajeres= false;
                        }
                    }
                });
                if(mensajeres){
                   window.location="index.php?controlador=Reorganization&accion=verifyReorganization";
                }else{
                    parent.message(textodelmen,"images/iconos_alerta/error.png"); 
                    $('#loader').css('display', 'none');
                    $("#siguiente").removeAttr("disabled");
                    $("#siguiente").addClass("buscarButton");
                    $("#siguiente").removeClass("buscarButtonDis");
                    $("#CancelAll").removeAttr("disabled");
                    $("#CancelAll").addClass("buscarButton");
                    $("#CancelAll").removeClass("buscarButtonDis");
                } 
                
            }else{
                parent.message("Verifique la cantidad ingresada para el producto del paso 2","images/iconos_alerta/error.png"); 
                $('#loader').css('display', 'none');
                $("#siguiente").removeAttr("disabled");
                $("#siguiente").addClass("buscarButton");
                $("#siguiente").removeClass("buscarButtonDis");
                $("#CancelAll").removeAttr("disabled");
                $("#CancelAll").addClass("buscarButton");
                $("#CancelAll").removeClass("buscarButtonDis");
            }
        }
    } 
    
    function confirmfunction(id){ 
        $('#nombrep4').html($('#'+id).attr('callback'));                
        $('.callback2').trigger('click');        
        $('#accept2').click(function(){                                       
            $.ajax({ 
                type: "POST",
                url: $('#'+id).attr('tar'),
                dataType: "json",   
                data: {verify:$('#'+id).attr('verify')},
                success: function(data){  
                    if(data.res=='si'){                         
                        oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));                        
                        $.fancybox.close();
                        parent.message("Se ha eliminado el producto de la reorganizaci&oacute;n","images/iconos_alerta/ok.png");
                    }else{
                        $.fancybox.close();
                        parent.message("No se pudo eliminar el producto de la reorganizaci&oacute;n","images/iconos_alerta/error.png");
                    } 
                }               
            }); 
        }); 
        $('#cancel2').click(function(){
            $.fancybox.close();            
        });
    }    
    
     
    function seleccionar(id,item){   
        var cant = $.trim($("#cantdev"+item).val());
        if(cant == ""){            
            $("#agregarpr"+item).attr("disabled", "disabled");
            $("#agregarpr"+item).removeClass("buscarButton");
            $("#agregarpr"+item).addClass("buscarButtonDis");
        }else{  
            if($("#agregarpr"+item).html()=='Agregar'){
                $.ajax({         
                    type: "POST",                    
                    url: "index.php?controlador=Reorganization&accion=addReorganizationps",
                    dataType: "json",     
                    data: {cant: parseFloat(cant),idpro: $("#"+id).attr("idck"),estado: "Remover"},
                    success: function(data){      
                        $("#agregarpr"+item).removeAttr('disabled');                                        
                        $("#agregarpr"+item).addClass("buscarButton");
                        $("#agregarpr"+item).removeClass("buscarButtonDis");
                        $("#agregarpr"+item).html("Remover"); 
                        $("#agregarpr"+item).css('background-color', '#ff4040');  
                        parent.message("Se ha agregado el producto","images/iconos_alerta/ok.png");
                    }                      
                });                   
            }else{ 
                $("#agregarpr"+item).removeAttr('disabled');
                $.ajax({     
                    type: "POST",                   
                    url: "index.php?controlador=Reorganization&accion=deleteItemps",
                    dataType: "json",    
                    data: {idpro: $("#"+id).attr("idck")}, 
                    success: function(data){  
                        if(data.res=='si'){
                            $("#agregarpr"+item).html("Agregar");
                            $("#agregarpr"+item).css('background-color','#999');
                            $("#agregarpr"+item).css('color','#444');
                            $("#agregarpr"+item).attr("disabled", "disabled");
                            $("#agregarpr"+item).removeClass("buscarButton");
                            $("#agregarpr"+item).addClass("buscarButtonDis");  
                            $("#cantdev"+item).val("");               
                            parent.message("Se ha removido el producto","images/iconos_alerta/ok.png");                             
                        }
                    }                       
                });                
            } 
        }  
    }     
    
    function actualizar(id,item){      
        var cant = $.trim($("#cantdev"+item).val());                        
        if(cant<="0" || cant == ""){                        
            $("#agregarpr"+item).attr('disabled','disabled');
            $.ajax({         
                type: "POST",                   
                url: "index.php?controlador=Reorganization&accion=deleteItemps",
                dataType: "json",          
                data: {idpro: item},
                success: function(data){      
                    $("#agregarpr"+item).html("Agregar");
                    $("#agregarpr"+item).css('background-color','#999');
                    $("#agregarpr"+item).css('color','#444');
                    $("#agregarpr"+item).attr("disabled", "disabled");
                    $("#agregarpr"+item).removeClass("buscarButton");
                    $("#agregarpr"+item).addClass("buscarButtonDis");                            
                    $("#cantdev"+item).val("");                                                                                   
                }                      
            });   
        }else if($('#ref1'+item).val()==$('#ref2'+item).val()){ 
            parent.message("No puede reorganizar el mismo producto seleccionado en el paso 2","images/iconos_alerta/error.png");
            $("#cantdev"+item).val(""); 
        }else if(cant>parseFloat($.trim($('#stock'+item).val()))){ 
            parent.message("La cantidad ingresada es mayor al stock","images/iconos_alerta/error.png");
            $("#agregarpr"+item).attr('disabled','disabled');
            $.ajax({         
                type: "POST",                   
                url: "index.php?controlador=Reorganization&accion=deleteItemps",
                dataType: "json",          
                data: {cant: 1,idpro: item ,estado: "Remover"},
                success: function(data){      
                    $("#agregarpr"+item).html("Agregar");
                    $("#agregarpr"+item).css('background-color','#999');
                    $("#agregarpr"+item).css('color','#444');
                    $("#agregarpr"+item).attr("disabled", "disabled");
                    $("#agregarpr"+item).removeClass("buscarButton");
                    $("#agregarpr"+item).addClass("buscarButtonDis");                            
                    $("#cantdev"+item).val("");                                                                                    
                }                      
            });   
        }else{       
            $("#agregarpr"+item).removeAttr('disabled');                                
            $("#agregarpr"+item).addClass("buscarButton");
            $("#agregarpr"+item).removeClass("buscarButtonDis");
            $.ajax({     
                type: "POST",                  
                url: "index.php?controlador=Reorganization&accion=addReorganizationps",
                dataType: "json",      
                data: {cant: parseFloat(cant), idpro: item, estado: "Remover"},  
                success: function(data){        
                    $("#agregarpr"+item).html("Remover");
                    $("#agregarpr"+item).css('background-color', '#ff4040');                       
                }      
            });                
        }
        
    }  
    
    function cancelarsesion(id){    
        $('.callback').trigger('click');          
        $('#accept').click(function(){                                          
            $.ajax({       
                type: "POST",         
                url: $('#'+id).attr('tar'),
                dataType: "json",   
                success: function(data) {       
                    if(data.res=='si'){        
                        parent.message("Se ha cancelado la reorganizacion","images/iconos_alerta/ok.png"); 
                        parent.$.fancybox.close(); 
                    }else{ 
                        $.fancybox.close();    
                        parent.message("No se pudo cancelar la reorganizacion","images/iconos_alerta/error.png");
                    } 
                }               
            });
        });  
        $('#cancel').click(function(){
            $.fancybox.close();            
        });
          
    }      
 
    function eliminardetalle(item){    
        var verify = encodeURIComponent(item) 
        $.ajax({        
            type: "POST",                        
            url: "index.php?controlador=Reorganization&accion=deleteItemp",
            dataType: "json",     
            data: { verify: verify  },
            success: function(data) 
            {  
                if(data.res=='si'){ 
                    oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));   
                }else{         
                    parent.message("No se pudo eliminar el item","images/iconos_alerta/error.png");
                }
            }  
        });  
                   
    }   
  
    function createdata(id,referencia,nombre,stock,idcode,idverify){      
        var inputcantid;    
        inputcantid="<input \n\
                      name='cantidad' \n\
                      label='cantidad' \n\
                      patt='val2' \n\
                      minsize='1'  \n\
                      size='7' \n\
                      maxlength='5' \n\
                      class='evento"+id+"' \n\
                      presence='val1' \n\
                      id='cantretirar"+id+"'\n\
                      onkeypress='return validar(event)'/>";
        var addId = $('#example2').dataTable().fnAddData([
            referencia,    
            nombre,   
            stock ,
            inputcantid,   
            "<a id='dell"+idcode+"' callback='"+nombre+"' tar='index.php?controlador=Reorganization&accion=deleteItempps' verify='"+idverify+"' href='#' onclick='confirmfunction($(this).attr(\"id\"))'> <img class='delete' src='images/delete.gif' title='Eliminar item'/> </a>"
        ]);     
        var theNode = $('#example2').dataTable().fnSettings().aoData[addId[0]].nTr;
        theNode.setAttribute('id',id); 
        $(".evento"+id).keyup(function(){             
            $.ajax({      
                type: "POST",                            
                url: 'index.php?controlador=Reorganization&accion=guardarCantps',
                dataType: "json",                      
                data: {cajas:($("#areorgn input[name='cantidad']").val())}                  
            });  
        }); 
        $("input").unbind("focus");
        $("input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
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
        $('#categorias').val("<?php echo $categoriaselected; ?>"); 
        $("#categorias").change(function(){                                       
            window.location='index.php?controlador=Reorganization&accion=reorganizarProductos&idcat='+$('#categorias').val();  
        });  
        //funcion1 
        $("#addToOut").click(function(){
            $("#addToOut").attr("disabled", "disabled");
            $('.error_input').remove();             
            if($("#codeprod").val()){  
                $.ajax({
                    type: "POST",                 
                    url: "index.php?controlador=Reorganization&accion=addNewItemps",
                    dataType: "json", 
                    data: {idpro:$("#codeprod").val()},
                    success: function(data){   
                        if(data.res=='si'){ 
                            $("#addToOut").removeAttr("disabled", "disabled");                                                                                           
                            createdata(data.pro.id,data.pro.referencia, data.pro.nombre, data.pro.stock,0, data.pro.verify,data.pro.code)      
                            $("#codeprod").val("");                  
                            if($("#tbodyex tr").size()>1)
                            {                            
                                $.ajax({        
                                    type: "POST",                         
                                    url: "index.php?controlador=Reorganization&accion=deleteItempps",
                                    dataType: "json",     
                                    data: { verify: data.pro.verify  },
                                    success: function(data) 
                                    {   
                                        if(data.res=='si'){  
                                            oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));
                                            parent.message("Solo se puede reorganizar un producto a la vez","images/iconos_alerta/error.png");
                                        }else{         
                                            parent.message("No se pudo eliminar el item","images/iconos_alerta/error.png");
                                        }
                                    } }); 
                              
                            }   
                            else { 
                                parent.message("Se ha agregado el producto ","images/iconos_alerta/ok.png");
                                //window.location="index.php?controlador=Reorganization&accion=reorganizarProducto&idcat="+$('#categorias').val();    
                            } 
                        }else{
                            $("#addToOut").removeAttr("disabled", "disabled");
                            $("#codeprod").val("");  
                            $('#codeprod').css("background-color","#F0CBBA");
                            $('#codeprod').after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;margin-top: 5px">'+data.mess+'</div>');                
                        }
                    }               
                });
            }else{
                $("#addToOut").removeAttr("disabled", "disabled");
                $('#codeprod').css("background-color","#F0CBBA");
                $('#codeprod').after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;margin-top: 5px">Referencia requerida</div>');                
            }  
        });
 
        //datatable
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
                null,
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false }
            ]
        } );  
        oTable=$('#example2').dataTable( {
            "fnCreatedRow": function( nRow, aData, iDataIndex ) { 
                $(nRow).addClass("class1");
                $('td:eq(0)', nRow).addClass('init2');
                $('td:eq(1)', nRow).addClass('item2');
                $('td:eq(2)', nRow).addClass('item2');
                $('td:eq(3)', nRow).addClass('item2');                                
                $('td:eq(3)', nRow).css('text-align','center'); 
                $('td:eq(2)', nRow).css('text-align','center'); 
                $('td:eq(4)', nRow).css('text-align','center');                   
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
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [ 
                null,    
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false },
                { "bSortable": false, "bSearchable": false } 
            ]
        } ); 
            
        $(".callback").fancybox({      
            'autoDimensions'       : false,
            'width'                : 400,
            'height'               : 130, 
            'autoScale'            : false,
            'overlayOpacity'       : 0.1,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'fade',
            'speedIn'              :  500,                        
            'hideOnOverlayClick'   : false,
            'overlayColor'         : '#000',
            'showCloseButton'      : false,
            'padding'              : 0, 
            'margin'               : 0
        }); 
  
        $(".callback2").fancybox({      
            'autoDimensions'       : false,
            'width'                : 400,
            'height'               : 130, 
            'autoScale'            : false,
            'overlayOpacity'       : 0.1,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'fade',
            'speedIn'              :  500,                        
            'hideOnOverlayClick'   : false,
            'overlayColor'         : '#000',
            'showCloseButton'      : false,
            'padding'              : 0, 
            'margin'               : 0
        });  
        $("#search").fancybox({                  
            'width'                : '100%',
            'height'               : '100%',
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500, 
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false,
            'showCloseButton'      : true 
        });
        $("input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });
</script>