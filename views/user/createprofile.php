<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<style>
    input[type="text"] {
        border-top-width: 1px;
        padding-top: 0;
        width: 251px !important;
    }
</style>
<form action="index.php?controlador=Profiles&accion=createNewProfile" method="POST" id="formprofile87612">  
<div class="container" style="margin-bottom: 20px; margin-top: 15px">     
    <table cellspacing="10" style="width: 100%;" align="center">  
        <tr>
            <td colspan="2" style="font-size: small">
               A continuaci&oacute;n diligencie la informaci&oacute;n del nuevo perfil, los campos que tienen asterisco "(*)" son obligatorios.
            </td>              
        </tr>
        <tr>
            <td style="vertical-align: top; width:180px;font-weight: bold">Seleccione grupo del perfil: </td>
            <td style="vertical-align: center;text-align: left;">                        
                <select name="grupoperfil" id="grupoperfil">                    
                    <option value="Administrador">
                        Administrador
                    </option>
                    <option value="Cajero">
                        Cajero
                    </option>
                    <option value="Estudiante">
                        Estudiante
                    </option>
                    <option value="No usuario">
                        No usuario
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top; width:180px;font-weight: bold">Nombre del perfil (*): </td>
            <td style="vertical-align: top;text-align: left">                        
                <?php
                $view->input("nombreperfil",
                        "text", 
                        "Nombre perfil",
                        array('required' => true, 'text' => 'regular', 'minsize' => '5', 'norepeat' => 'val4'),
                        array('maxlength' => '50'));
                ?>                        
            </td>
        </tr>
        <tr>
                    <td colspan="2" style="font-size: small">
                       A continuaci&oacute;n seleccione los modulos a los que podra tener acceso su nuevo perfil.
                    </td>              
                </tr>
    </table>
                <?php
                foreach ($menus as $key => $value) {

                    if (!(($key == 'Usuarios' || $key == 'Inventario' || $key == 'Reportes' || $key == 'Caja') && ($group == 'Estudiante' || $group == 'No usuario'))) {
                        if (!(($key == 'Oficina Personal' || $key == 'Caja') && ($group == 'Superadministrador'))) {
                            if (!(($key == 'Caja' || $key == 'Usuarios') && ($group == 'Administrador'))) {
                                if (!(($key == 'Oficina Personal' || $key == 'Usuarios') && ($group == 'Cajero'))) {
                                    ?>
                        <div style="width: 98%;">
                            <fieldset class="colorleyend" style="width: 100%;">
                                <legend class="colorleyendinto"><?php echo $key; ?></legend>
                                <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 90%;margin: 0 auto;">        
                                    <tr class="headall">    
                                        <th class="headinit">icono</th> 
                                        <th class="head">Nombre del menu</th>
                                        <th class="head">Habilitado</th>                                    
                                    </tr>      
                    <?php
                    $estilo = 1;
                    foreach ($value as $value2) {
                        ?>
                                        <tr class="class<?php echo $estilo; ?>">   
                                            <th class="init" style="text-align: center;width: 105px;">
                                                <img src="<?php echo $value2['iconsub']; ?>" height="45"/>
                                            </th>
                                            <th class="item" style="text-align: left;padding-left: 10px"> 
                        <?php echo $value2['nombresub']; ?>
                                            </th>
                                            <th class="item" style="text-align: center;width: 99px;">
                                                <input type="checkbox" name="permission[]" value="<?php echo $value2['idsub']; ?>"/>
                                            </th>                               
                                        </tr>
                        <?php
                        if ($estilo == 1) {
                            $estilo = 2;
                        } else {
                            $estilo = 1;
                        }
                    }
                    ?> 
                                </table>  
                            </fieldset>
                        </div>  
                                    <?php
                                }
                            }
                        }
                    }
                }
                ?>    
    <button class="buscarButton" style="float: left;height: 40px; margin-left: 5%" id="finish">Crear perfil</button>          
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
</div> 
</form>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    function message(mensaje,imagen){        
        $("#titlemesagge",window.parent.document).html("<strong>"+mensaje+"<strong/>");
        $("#iconmesagge",window.parent.document).html(" <img src='"+imagen+"'/>");       
        $("#barraf",window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf",window.parent.document).slideUp(1000).fadeOut(400);  
    }
    $(document).ready(function() {           
        $("#grupoperfil").val('<?php echo $group; ?>');
        $("#grupoperfil").change(function(){
            window.location="index.php?controlador=Profiles&accion=createProfile&groupselect="+$("#grupoperfil").val();
        });        
        $('#finish').click(function() {
            $('#formprofile87612').ajaxForm({
                dataType: 'json',
                beforeSubmit: function() {
                    $('#finish').attr('disabled', 'disabled');
                    $("#finish").addClass("buscarButtonDis");
                    $("#finish").removeClass("buscarButton");
                    $('#loader').css('display', 'block');                    
                        if (validates("formprofile87612")) {                           
                                return true;
                        } else {
                            $('#loader').css('display', 'none');
                            $('#finish').removeAttr('disabled');
                            $("#finish").addClass("buscarButton");
                            $("#finish").removeClass("buscarButtonDis");
                            return false;
                        }                    
                },
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    $('#loader').css('display', 'none');
                    $('#finish').removeAttr('disabled');
                    $("#finish").addClass("buscarButton");
                    $("#finish").removeClass("buscarButtonDis");
                    if (responseText.respuesta == 'si') {
                        parent.createdata(responseText.id,responseText.nombre,responseText.grupo,responseText.idid,responseText.verify);
                        parent.message('Se ha creado un nuevo perfil', 'images/iconos_alerta/ok.png');
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'no') {
                        parent.message('No se ha podido crear el peril', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    }
                }
            });
        });    
        $("#formprofile87612 input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });    
</script>