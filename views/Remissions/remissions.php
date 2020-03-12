<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?> 
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Remisiones: Crear nueva remisi&oacute;n</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px"> 
    <div style="width: 100%;">    
        <fieldset class="colorleyend" style="width: 100%; padding: 10px">
            <legend class="colorleyendinto">Bodega origen</legend>
            <form method="POST" action="">
                <div id="cajaselect" style="margin-bottom: 15px">
                    <?php if ($grupoperfil == "Superadministrador") { ?>
                        Seleccione la bodega:      
                        <select id="bodegas">         
                            <?php foreach ($bodegas as $value) { ?> 
                                <option id="nombrebod" value="<?php echo $value["id"] ?>" > 
                                    <?php echo $value["nombre"] ?>
                                </option>              
                            <?php } ?>  
                        </select> &nbsp; 
                    <?php } else { ?>
                        <?php foreach ($bodegas as $value) { ?> 

                            <?php if ($idbodega == $value["id"]) { ?>
                                Bodega:
                                <input type="text" value="<?php echo $value["nombre"] ?>" disabled="disabled"/>
                                <input id="bodegas" type="hidden" value="<?php echo $idbodega ?>"/> &nbsp;
                            <?php } ?> 
                        <?php } ?> 
                    <?php } ?>
                    <label>Encargado</label>&nbsp;<input id="usuarioorigen" type="text" value="<?php echo $usuario["nombreu"] ?>" size="99%" disabled="disabled"/> 
                </div>                                          
            </form>
        </fieldset>   
    </div>    
    <div  style="width: 100%;">
        <fieldset class="colorleyend" style="width: 100%;padding: 10px">
            <legend class="colorleyendinto">Bodega destino</legend>
            <div id="cajaselect" style="margin-bottom: 15px"> 
                <table border="0" width="100%" style="line-height: 15px"><tr><td>Seleccione la bodega: </td> 
                        <td>
                            <select id="bodegadestino">     
                                <?php foreach ($bodegaslocal as $value) { ?> 
                                    <option id="nombrebod" value="<?php echo $value["id"] ?>" > 
                                        <?php echo $value["nombre"] ?>
                                    </option>         
                                <?php } ?>       
                            </select> 
                        </td>                 
                        <td style="width: 70%"></td>            
                        <td></td>
                    </tr>
                </table>
            </div>     
            <div id="expandir2" class="expandir">     
                <h3>Confirmar remision</h3>
                <div>                              
                        <div style="margin-top: 0px;margin-bottom: 20px"> 
                            <table id="mytable" class="table" border="0" cellspacing="0" cellpadding="0">      
                                <thead>   
                                    <tr class="headall">     
                                        <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                                        <th class="head">Referencia</th>
                                        <th class="head" style="cursor: pointer;">Cant</th>
                                        <th class="head" style="cursor: pointer;">Vr Unit</th>  
                                        <th class="head" style="cursor: pointer;">Vr Total</th> 
                                        <th class="head">Eliminar</th>                      
                                    </tr>       
                                </thead>   
                                <tbody style="text-align: center; line-height: 25px">      
                                    <?php
                                    if (sizeof($remisiones)!=0) {
                                        foreach ($remisiones as $value) {
                                            ?>     
                                            <tr id="<?php echo $value["id"] ?>">   
                                                <td class="init2">   
                                                    <?php echo $value["nombre"] ?>
                                                </td>              
                                                <td class="item2"> 
                                                    <?php echo $value["referencia"] ?>
                                                </td>      

                                                <td class="item2" id="cantid<?php echo $value["id"] ?>">    
                                                    <?php echo $value["cantidad"] ?>
                                                </td>      
                                                <td class="item2" id="costocantid<?php echo $value["id"] ?>">  
                                                    <?php echo '&#36;' . number_format($value["costo"], 0, ',', '.'); ?> 
                                                </td>      
                                                <td class="item2" id="totalcantid<?php echo $value["id"] ?>">  
                                                    <?php echo '&#36;' . number_format($value["total"], 0, ',', '.'); ?>
                                                </td>           
                                                <td class="item2">             
                                                    <a id="dell<?php echo $value['id']; ?>" href="#"     
                                                       onclick="eliminardetalle($(this).attr('id'))" idck="<?php echo $value["id"] ?>">   
                                                        <img class="delete" src="images/delete.gif" title="Eliminar item"/> 
                                                    </a>                                                
                                                </td>   
                                            </tr>     
                                        <?php }
                                    } ?>                                        
                                </tbody>  
                            </table>     
                        </div> 
                                <a id="dell<?php echo sha1($value['id']); ?>"  style="margin-left: auto; margin-right: auto"
                                   callback="<?php echo $value['nombre']; ?>" 
                                   tar="index.php?controlador=Remissions&accion=confirmarRemision" 
                                   verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                   href="#" 
                                   onclick="confirmfunction($(this).attr('id'))">
                                    <button id="boton" class="buscarButton" style="height: 40px">Confirmar remision</button>
                                </a>                                                                                        
                                <a id="allcancel"  style="margin-left: auto; margin-right: auto"
                                   callback="<?php echo $value['nombre']; ?>" 
                                   tar="index.php?controlador=Remissions&accion=cancelarsesion" 
                                   verify="<?php echo strrev(urlencode(base64_encode($value['id']))); ?>" 
                                   href="#"      
                                   onclick="cancelarsesion($(this).attr('id'))">  
                                    <button id="cancelar" class="buscarButton" style="height: 40px">Cancelar remision</button>
                                </a> 
                                <div id="loader" style="margin-left: auto; margin-right: auto; display: none">
                                        <img src="images/ajax-loader.gif"/> Procesando...
                                </div>                    
                    </div>                                                                                                                                                                                                                        
                </div>             
        </fieldset> 
    </div>  
    <div style="float: left;width: 100%;"> 
        <fieldset class="colorleyend" style="width: 100%; padding: 10px">
            <legend class="colorleyendinto">Selecci&oacute;n de productos de <?php echo $detalles[1]["nombrebodega"] ?> a remisionar</legend>   
            <div id="cajaselect" style="margin-bottom: 15px; margin-top: 20px"> 
                Seleccione categoria:    
                <select id="categorias" name="idcat">
                    <?php foreach ($categorias as $key => $value) { ?>
                        <option value="<?php echo $key ?>">
                            <?php echo $value ?>
                        </option>       
                    <?php } ?>  
                </select>           
            </div>
            <div style="margin-top: 0px;margin-bottom: 20px">
                <form name="formulario">      
                    <table class="table" border="0" cellspacing="0" cellpadding="0" id="example">    
                        <thead>   
                            <tr class="headall">     
                                <th class="headinit" style="cursor: pointer;">Nombre del producto</th>                        
                                <th class="head">Referencia</th>                                 
                                <th class="head">Stock</th>  
                                <th class="head" style="cursor: pointer;">Cantidad</th>
                                <th class="head" style="cursor: pointer;">Costo</th>                                                                                      
                            </tr>   
                        </thead>   
                        <tbody> 
                            <?php
                            $estilo = 1;
                            foreach ($detalles[0] as $value) {
                                ?>     
                                <tr class="class<?php echo $estilo; ?>" id="<?php echo $value["id"] ?>">  
                                    <td class="init2" style="width: 450px;" > 
                                        <?php echo $value["nombre"] ?>
                                    </td>  
                                    <td class="item2" style="width: 40px;">
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
                                            if (isset($_SESSION['remision'][$value["id"]])) {
                                                $view->input("cantdev", "numeric", "cantidad devolucion", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                                    'maxlength' => '5',
                                                    "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                                    "id" => "cantdev" . $value["id"],
                                                    "item" => $value["id"],
                                                    "value" => $_SESSION['remision'][$value["id"]]));
                                            } else {
                                                $view->input("cantdev", "numeric", "cantidad devolucion", array('required' => true, 'text' => 'numeric', 'minsize' => '1'), array('size' => '5',
                                                    'maxlength' => '5',
                                                    "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                                    "id" => "cantdev" . $value["id"],
                                                    "item" => $value["id"]));
                                            }
                                        } else {
                                            if (isset($_SESSION['remision'][$value["id"]])) {
                                                $view->input("cantdev", "text", "cantidad devolucion", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('size' => '5',
                                                    'maxlength' => '5',
                                                    "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                                    "id" => "cantdev" . $value["id"],
                                                    "item" => $value["id"],
                                                    "value" => $_SESSION['remision'][$value["id"]]));
                                            } else {
                                                $view->input("cantdev", "text", "cantidad devolucion", array('required' => true, 'text' => 'decimal', 'minsize' => '1'), array('size' => '5',
                                                    'maxlength' => '5',
                                                    "onkeyup" => "actualizar($(this).attr(\"id\"),$(this).attr(\"item\"))",
                                                    "id" => "cantdev" . $value["id"],
                                                    "item" => $value["id"]));
                                            }
                                        }
                                        ?>           
                                    </td> 
                                    <td class="item2" style="width: 10px;text-align: center;" id="pricefull<?php echo $value["id"] ?>">
                                        <?php echo '&#36;' . number_format($value["costo"], 0, ',', '.'); ?>                                   
                                    </td>                                                               
                                </tr>
                                        <?php
                                        if ($estilo == 1) {
                                            $estilo = 2;
                                        } else {
                                            $estilo = 1;
                                        }
                                    }
                                    ?>
                        </tbody>
                    </table>
                </form>
            </div>               
        </fieldset>
    </div> 
    <div style="clear: left"></div>
</div>
        </div>
    </div>
<div style="display: none">
    <div id="contentcall">    
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de realizar la remisi&oacute;n?
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
            Esta seguro de cancelar la remisi&oacute;n?
        </div>  
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept2">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel2">CANCELAR</button>
        </div>
    </div>
</div>  
<div style="display: none">
    <div id="contentcall3">      
        <div style="text-align: center; margin-bottom: 12px;margin-top: 40px;padding-left: 20px;padding-right: 20px; font-size: 12px">
            Esta seguro de cambiar de bodega, perderá los datos de la remision de <strong><?php echo $detalles[1]["nombrebodega"] ?></strong>?
        </div>  
        <div style="text-align: center; margin-bottom: 12px;">
            <button class="buscarButton" id="accept3">ACEPTAR</button>    
            <button style="margin-left: 10px" class="buscarButton" id="cancel3">CANCELAR</button>
        </div>
    </div>
</div>   
<div style="display: none"> 
    <a href="#contentcall" class="callback">Open Example</a>
    <a href="#contentcall2" class="callback2">Open Example</a>
    <a href="#contentcall3" class="callback3">Open Example</a>
</div>
<script>
    var oTable;   
    eval("<?php echo $mensaje?>");
    function confirmfunction(id){       
        var contin;
        var mensaje;
        $.ajax({   
            type: "POST",               
            url: "index.php?controlador=Remissions&accion=validarRemision",
            dataType: "json",   
            async: false,
            success: function(data){        
                contin=data.res;
                mensaje=data.mensaje;
            }               
        }); 
        if(contin== "no" ){               
            message(mensaje,"images/iconos_alerta/error.png");    
        } else{         
            $('.callback').trigger('click');        
            $('#accept').click(function(){   
                $('#loader').css('display', 'block');
                $("#boton").attr("disabled", "disabled");
                $("#boton").addClass("buscarButtonDis");
                $("#boton").removeClass("buscarButton");
                $("#cancelar").attr("disabled", "disabled");
                $("#cancelar").addClass("buscarButtonDis");
                $("#cancelar").removeClass("buscarButton");
                if($("#bodegas").val() == $("#bodegadestino").val()){
                    $('#loader').css('display', 'none');
                    $("#boton").removeAttr("disabled", "disabled");
                    $("#boton").addClass("buscarButton");
                    $("#boton").removeClass("buscarButtonDis");
                    $("#cancelar").removeAttr("disabled", "disabled");
                    $("#cancelar").addClass("buscarButton");
                    $("#cancelar").removeClass("buscarButtonDis");
                    $.fancybox.close();          
                    message("No se pueden realizar remisiones dentro de la misma bodega","images/iconos_alerta/error.png");  
                    $("#bodegadestino").css('background-color', '#ff4040');    
                } else{             
                    $.ajax({   
                        type: "POST",               
                        url: $('#'+id).attr('tar')+"&boddestino="+$("#bodegadestino").val(),
                        dataType: "json", 
                        data: {verify:$('#'+id).attr('verify')},
                        success: function(data) 
                        {        
                            if(data.res=='si'){                
                                $.fancybox.close();   
                                window.location="index.php?controlador=Remissions&accion=inizialiteRemision&mensaje=message('Se ha realizado la remision', 'images/iconos_alerta/ok.png');";                                   
                            }else{   
                                $('#loader').css('display', 'none');
                                $("#boton").removeAttr("disabled", "disabled");
                                $("#boton").addClass("buscarButton");
                                $("#boton").removeClass("buscarButtonDis");
                                $("#cancelar").removeAttr("disabled", "disabled");
                                $("#cancelar").addClass("buscarButton");
                                $("#cancelar").removeClass("buscarButtonDis");
                                $.fancybox.close();   
                                message("No se pudo realizar la remision","images/iconos_alerta/error.png");
                            }      
                        }               
                    });               
                }  
            });
            $('#cancel').click(function(){
                $('#loader').css('display', 'none');
                $("#boton").removeAttr("disabled", "disabled");
                $("#boton").addClass("buscarButton");
                $("#boton").removeClass("buscarButtonDis");
                $("#cancelar").removeAttr("disabled", "disabled");
                $("#cancelar").addClass("buscarButton");
                $("#cancelar").removeClass("buscarButtonDis");
                $.fancybox.close();            
            });
        } 
    }    
   
    function cancelarsesion(id){             
        $('.callback2').trigger('click');          
        $('#accept2').click(function(){                                          
            $.ajax({     
                type: "POST",         
                url: $('#'+id).attr('tar'),
                dataType: "json",
                data: {verify:$('#'+id).attr('verify')},
                success: function(data) {     
                    if(data.respuesta=='ok'){                      
                        $.fancybox.close();                             
                        window.location="index.php?controlador=Remissions&accion=inizialiteRemision&mensaje=message('Se ha cancelado la remision','images/iconos_alerta/ok.png');";                           
                    }else{ 
                        $.fancybox.close(); 
                        message("No se pudo cancelar la remision","images/iconos_alerta/error.png");
                    } 
                }               
            });
        });
        $('#cancel2').click(function(){
            $.fancybox.close();            
        });        
    }           
         
    function createdata(id,nombreproducto,referencia,stock,cantidad,costo,total){                                  
        var addId = $('#mytable').dataTable().fnAddData([     
            nombreproducto,   
            referencia,       
            cantidad,          
            '$'+toCurrency(costo),          
            '$'+toCurrency(total),   
            "<a idck='"+id+"' id='dell"+id+"' href='#' ' onclick='eliminardetalle($(this).attr(\"id\"))'><img src='images/delete.gif' class='delete'/></a>"
        ]         
    );     
        var theNode = $('#mytable').dataTable().fnSettings().aoData[addId[0]].nTr;
        theNode.setAttribute('id',id);   
    }                 
    
    function eliminardetalle(id){    
        $("#cantdev"+$("#"+id).attr("idck")).val(''); 
        $.ajax({       
            type: "POST",                        
            url: "index.php?controlador=Remissions&accion=eliminardetalle",
            dataType: "json",     
            data: {producto:($("#"+id).attr("idck"))},
            success: function(data){ 
                if(data.res=='si'){ 
                    oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));   
                    message("Se ha eliminado el producto de la remisi&oacute;n","images/iconos_alerta/ok.png");                    
                }else{         
                    message("No se pudo eliminar el item","images/iconos_alerta/error.png");
                }
            }  
        });          
    }
        
        
    function actualizar(id,item){         
        var stock        = parseFloat($("#stock"+item).val());
        var cant         = parseFloat($("#"+id).val().replace(",", "."));              
        var costocantid  = $.trim($("#pricefull"+item).html().replace("$","").replace(".","").replace(",","."));    
        var total        =  cant*costocantid;             
        if(cant > stock){   
            $.ajax({       
                type: "POST",                        
                url: "index.php?controlador=Remissions&accion=eliminardetalle",
                dataType: "json",                     
                data: {producto:item},
                success: function(data){ 
                    if(data.res=='si'){ 
                        oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));                             
                    }
                }  
            }); 
            $("#"+id).val(""); 
            message('La cantidad ingresada es superiora la que hay en stock','images/iconos_alerta/error.png');                                                     
        }else if(!cant || cant <=0){    
            $.ajax({       
                type: "POST",                        
                url: "index.php?controlador=Remissions&accion=eliminardetalle",
                dataType: "json",     
                data: {producto:item},
                success: function(data){ 
                    if(data.res=='si'){ 
                        oTable.fnDeleteRow(oTable.fnGetPosition($('#'+data.idrow).get(0)));                             
                    }
                }  
            });                  
        }else{     
            $.ajax({   
                type: "POST",                       
                url: 'index.php?controlador=Remissions&accion=agregarItem&bodorigen='+$('#bodegas').val(),
                dataType: "json",          
                data: {cantidad:$("#"+id).val(), idproducto :item },
                success: function(data){ 
                    if(data.respuesta=="si"){
                        createdata(data.id,data.nombreproducto,data.referencia,data.stock,data.cantidad,data.costo,data.total);
                        $('#cantid'+item).html(cant);                        
                        $('#totalcantid'+item).html('&#36;'+toCurrency(total));   
                        $('#costocantid'+item).html('&#36;'+toCurrency(costocantid));   
                    }else if(data.respuesta=="sisi"){
                        $('#cantid'+item).html(cant);                        
                        $('#totalcantid'+item).html('&#36;'+toCurrency(total));   
                        $('#costocantid'+item).html('&#36;'+toCurrency(costocantid));    
                    }
                }       
            });    
            //  }       
        }                           
    }
    
       
    function toCurrency(cnt){
        cnt = cnt.toString().replace(/\$|\,/g,'');
        if (isNaN(cnt))
            return 0;    
        var sgn = (cnt == (cnt = Math.abs(cnt)));
        cnt = Math.floor(cnt * 100 + 0.5);
        cvs = cnt % 100;
        cnt = Math.floor(cnt / 100).toString();
        if (cvs < 10) 
            cvs = '0' + cvs;
        for (var i = 0; i < Math.floor((cnt.length - (1 + i)) / 3); i++)
            cnt = cnt.substring(0, cnt.length - (4 * i + 3)) + '.' + cnt.substring(cnt.length - (4 * i + 3));
        return (((sgn) ? '' : '-') + cnt + ',' + cvs);   
    }   
  
    new jQueryCollapse($("#expandir1"), { 
        open: function() { 
            this.slideDown(300);
        },
        close: function() {
            this.slideUp(300);
        }            
    }); 
 
    new jQueryCollapse($("#expandir2"), {    
        open: function() {
            this.slideDown(300);}, 
        close: function() {
            this.slideUp(300);}                 
    });    
         
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
        $("#bodegas").val("<?php echo $idbodega ?>");    
        $("#bodegadestino").val("<?php echo $idbodegades ?>");
        $("#bodegas").change(function(){ 
            $('.callback3').trigger('click');          
            $('#accept3').click(function(){                                                            
                $.ajax({       
                    type: "POST",                              
                    url: 'index.php?controlador=Remissions&accion=cancelarsesion',    
                    dataType: "json",     
                    data: {verify: <?php echo $idbodega ?>},
                    success: function(data) {     
                        if(data.respuesta=='ok'){                      
                            $.fancybox.close();        
                            window.location='index.php?controlador=Remissions&bodorigen='+$('#bodegas').val()+'&idcat='+$('#categorias').val()+'&boddes='+$('#bodegadestino').val();          
                        }else{   
                            $.fancybox.close();   
                            message("No se pudo cambiar de bodega","images/iconos_alerta/error.png");
                        } 
                    }         
                });   
            });
            $('#cancel3').click(function(){
                $.fancybox.close();   
                $("#bodegas").val("<?php echo $idbodega ?>");           
            });  
        });       
        $("#bodegadestino").change(function(){               
            if($("#bodegas").val() == $("#bodegadestino").val()) { 
                $("#bodegadestino").css('background-color', '#ff4040'); 
                message("No pueden realizar remisiones dentro de la misma bodega","images/iconos_alerta/error.png");
            }   
            else{  
                $("#bodegadestino").css('background-color', '#fff');         
                window.location='index.php?controlador=Remissions&bodorigen='+$('#bodegas').val()+'&idcat='+$('#categorias').val()+'&boddes='+$('#bodegadestino').val();    
            }                           
        });  
        $('#categorias').val("<?php echo $categoriaselected; ?>");        
        $("#categorias").change(function(){                                 
            window.location='index.php?controlador=Remissions&accion=inizialiteRemision&bodorigen='+$('#bodegas').val()+'&idcat='+$('#categorias').val()+'&boddes='+$('#bodegadestino').val();  
        });           
           
        $('img').css("border","0");
        $('#example').dataTable( { 
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
            ]					
        } );
          
        oTable=$('#mytable').dataTable({    
            "fnCreatedRow": function( nRow, aData, iDataIndex ) { 
                $('td:eq(0)', nRow).addClass('init2'); 
                $('td:eq(1)', nRow).addClass('item2');                 
                $('td:eq(2)', nRow).addClass('item2'); 
                $('td:eq(3)', nRow).addClass('item2'); 
                $('td:eq(4)', nRow).addClass('item2'); 
                $('td:eq(5)', nRow).addClass('item2'); 
                if($('td:eq(5) a', nRow).attr('idck')){    
                    $('td:eq(2)', nRow).attr('id','cantid'+$('td:eq(5) a', nRow).attr('idck')); 
                    $('td:eq(3)', nRow).attr('id', 'costocantid'+$('td:eq(5) a', nRow).attr('idck')); 
                    $('td:eq(4)', nRow).attr('id', 'totalcantid'+$('td:eq(5) a', nRow).attr('idck')); 
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
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                null,
                null, 
                null,
                null,
                null,
                null  
            ]	    				
        });                    
             
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
        
        $(".callback3").fancybox({      
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
        
        $(".various4").fancybox({
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
        
    });  
</script>


