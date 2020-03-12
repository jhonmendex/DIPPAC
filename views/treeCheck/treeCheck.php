<?php ?>
<script type='text/javascript'>
    function viewMe(user){         
        var elemento = $(".raiz"+user);
        var posicion = elemento.position();
        var element = $('.mainCompose');
        var posicion2 =element.position();
 
        if ($('.mainCompose').is (':hidden')){ 
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "index.php?controlador=TreeCheck&accion=dataGetNode",
                data: { idUser: user },
                success: function( response ) 
                { 
                    $('#nombre').html(response.nombre);
                    $('#alias').html(response.alias);
                    $('#codigo').html(response.id);
                    $('#telefono').html(response.telefono);
                    $('#email').html(response.email);
                    $('#celular').html(response.celular);   
                    $('#puntosp').html(response.puntosPeriodo);
                },
                error: function( error ){
                    alert( error );
                }
            }); 
            element.css('left', posicion.left-25);
            element.css('top', posicion.top+54); 
            $('.mainCompose').slideDown(800).fadeIn(200);
        }else{              
            if(Math.ceil(posicion.left)==Math.ceil(posicion2.left+25) && Math.ceil(posicion.top)==Math.ceil(posicion2.top-54)){
                $('.mainCompose').slideUp(800).fadeOut(200);
            }else{
                element.css('left', posicion2.left);
                element.css('top', posicion2.top); 
                $('.mainCompose').slideUp(0).fadeOut(0); 
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "index.php?controlador=TreeCheck&accion=dataGetNode",
                    data: { idUser: user },
                    success: function( response ) 
                    { 
                        $('#nombre').html(response.nombre);
                        $('#alias').html(response.alias);
                        $('#codigo').html(response.id);
                        $('#telefono').html(response.telefono);
                        $('#email').html(response.email);
                        $('#celular').html(response.celular);   
                        $('#puntosp').html(response.puntosPeriodo);
                    },
                    error: function( error ){
                        alert( error );
                    }
                });                
                element.css('left', posicion.left-25);
                element.css('top', posicion.top+54); 
                $('.mainCompose').slideDown(800).fadeIn(200);
            }                                        
        }                  
    }   
            
    function viewAll(user){                                                        
        var elemento = $(".nivel"+user);
        var posicion = elemento.position();
        var element = $('.mainCompose');
        var posicion2 =element.position();
 
        if ($('.mainCompose').is (':hidden')){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "index.php?controlador=TreeCheck&accion=dataGetNode",
                data: { idUser: user },
                success: function( response ) 
                { 
                    $('#nombre').html(response.nombre);
                    $('#alias').html(response.alias);
                    $('#codigo').html(response.id);
                    $('#telefono').html(response.telefono);
                    $('#email').html(response.email);
                    $('#celular').html(response.celular); 
                    $('#puntosp').html(response.puntosPeriodo);
                },
                error: function( error ){
                    alert( error );
                }
            });
            element.css('left', posicion.left-25);
            element.css('top', posicion.top+34); 
            $('.mainCompose').slideDown(800).fadeIn(200);
        }else{                                    
            if(Math.ceil(posicion.left)==Math.ceil(posicion2.left+25) && Math.ceil(posicion.top)==Math.ceil(posicion2.top-34)){
                $('.mainCompose').slideUp(800).fadeOut(200);
            }else{
                element.css('left', posicion2.left);
                element.css('top', posicion2.top); 
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "index.php?controlador=TreeCheck&accion=dataGetNode",
                    data: { idUser: user },
                    success: function( response ) 
                    { 
                        $('#nombre').html(response.nombre);
                        $('#alias').html(response.alias);
                        $('#codigo').html(response.id);
                        $('#telefono').html(response.telefono);
                        $('#email').html(response.email);
                        $('#celular').html(response.celular);
                        $('#puntosp').html(response.puntosPeriodo);
                    },
                    error: function( error ){
                        alert( error );
                    }
                });
                $('.mainCompose').slideUp(0).fadeOut(0);  
                element.css('left', posicion.left-25);
                element.css('top', posicion.top+34); 
                $('.mainCompose').slideDown(800).fadeIn(200);
            }                                        
        } 
    }
    google.load('visualization', '1', {packages:['orgchart']});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Name');
        data.addColumn('string', 'Manager');
        data.addColumn('string', 'ToolTip');                  
        var items= <?php echo $arbol ?>;
        var arbol=[];
        //item={v:'Mike', f:'Mike<div style="color:red; font-style:italic">President</div>'};                
        for (var v in items) {                    
            arbol[v]=[{v:items[v][0], f:items[v][3]},items[v][1],items[v][2]];
        }
        data.addRows(arbol);                
        var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));                
        chart.draw(data, {allowHtml:true});
        var cssObj = {
            'margin': '0px',
            'padding-top': '0px',
            'height': '46px',
            'cursor': 'default',
            'text-align':'center',
            'vertical-align': 'middle',
            'background-color': '#fff',
            'border': 'none',
            'border-radius': '0x 0px 0px 0px',
            'box-shadow': '0px 0px 0px rgba(0, 0, 0, 0.5)',
            'background': 'none'
        }
        var cssObj2 = {
            'background-color': '#fff',
            'border': 'none',
            'background': '#fff'
        }
        $('.google-visualization-orgchart-node').css(cssObj);
        $('.google-visualization-orgchart-nodesel').css(cssObj2);
    }        
    $(document).ready(function() {                
        $(".mainCompose").hide();  
        $("body").css("margin-top","0px");      
    });
</script>
<div style="float: left;">
    <fieldset class="colorleyend" style=" padding-top: 0px;">
        <legend><h2 style="margin-top: 3px; margin-bottom: 3px;"><?php $doc->texto('ORGANIZATION') ?></h2></legend>
        <table style="font-size: 12px" cellSpacing="0">
            <tr>
                <td style="padding-left: 25px; "><img src="images/iconos/empresario.png" width="15" height="22"/></td>
                <td style="padding-left: 8px;"><?php echo $nombrePadre ?></td> 
            </tr>
            <tr>        
                <td style="padding-left: 25px;"><img src="images/iconos/nivel1.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Activo</td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel2.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Reflexivo</td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel3.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Sensorial</td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel4.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Intuitivo</td>
            </tr>
             <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel4.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Visual</td>
            </tr>
             <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel4.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Verbal</td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel4.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Secuencial</td>
            </tr>
            <tr>
                <td style="padding-left: 25px;"><img src="images/iconos/nivel4.png" width="13" height="18"/></td>
                <td style="padding-left: 8px;">Estudiantes estilo Global</td>
            </tr>
        </table>
    </fieldset>
</div>
<div style="float: left;">
    <?php $view->startForm("index.php?controlador=TreeCheck", "formInscription"); ?>    
    <fieldset class="colorleyend" style="padding-top: 0px;">
        <legend><h2 style="margin-top: 3px; margin-bottom: 3px;"><?php $doc->texto('OPTIONS') ?></h2></legend>
        <table cellspacing="10" style="font-size: 12px;">
            <tr>
                <td style="vertical-align: top;text-align: right"><?php $doc->texto('LEVELS_SHOW') ?> </td>
                <td style="vertical-align: top">                        
                    <select name="levels" id="levels">       
                        <?php for($i=1; $i<=100; $i++){ 
                            if($nivel==$i){ ?>
                                <option value="<?php echo $i?>" selected="true"><?php echo $i?></option>
                                
                            <?php }else{?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php }                                                        
                        
                        } ?>
                    </select>                     
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top;text-align: right"><?php $doc->texto('TYPE_VIEW') ?> </td>
                <td style="vertical-align: top">
                    <select name="view">
                        <option value="tree">Mapa de red</option>                                             
                    </select>
                </td>                
            </tr>
            <tr>
                <td align="center" style="vertical-align: top;" colspan="2"><button class="buscarButton"><?php $doc->texto('SEE') ?></button></td>
            </tr>
        </table>
    </fieldset> 
    <?php $view->endForm(); ?>    

</div>

<div id='chart_div' style="clear: both;"></div>      

<div class="mainCompose" style="display: none; ">
    <div class="calloutUp">
        <div class="calloutUp2">
        </div>
    </div>	
    <div id="msgform">    
        <table border="0" cellspacing="0" style="width: 100%;">                    
            <tr class="headall">
                <th colspan="2" class="headinit" id="nombre" nowrap></th>
            </tr> 

            <tr class="class1">
                <td class="headinit">Alias</td>
                <td class="headother" id="alias"></td>
            </tr> 
            <tr class="class2">
                <td class="headinit">Id</td>
                <td class="headother" id="codigo"></td>
            </tr> 
            <tr class="class1">
                <td class="headinit">Email</td>
                <td class="headother" id="email"></td>
            </tr> 
            <tr class="class2">
                <td class="headinit">Telefono</td>
                <td class="headother" id="telefono"></td>
            </tr> 
            <tr class="class1">
                <td class="headinit">Celular</td>
                <td class="headother" id="celular"></td>
            </tr>
            <tr class="class2">
                <td class="headinit">PP</td>
                <td class="headother" id="puntosp"></td>
            </tr>

        </table>
    </div>
</div>  
