<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div align="center">  
    <table style="text-align: left; width: 90%">
            <tr>
                <td style="font-size: small; line-height: normal !important">
                    A continuaci&oacute;n diligencie la informaci&oacute;n del nuevo usuario, los campos que tienen asterisco "(*)" son obligatorios.
                </td>              
            </tr>
     </table>
    <form id="myform" action="index.php?controlador=ManageUsers&accion=insertUser" method="post">
    <fieldset class="colorleyend" style="width: 90%">
        <legend class="colorleyendinto"><?php $doc->texto('BASIC_INFORMATION') ?></legend>        
        <table cellspacing="10" style="width:100%; line-height: 20px" align="center">            
            <tr>
                <td style="vertical-align: middle"><?php $doc->texto('FULL_NAME') ?>: </td>
                <td style="vertical-align: middle">                        
                    <?php $view->input("full_name", 
                            "text",
                            $doc->t('FULL_NAME'),
                            array('required' => true, 'text' => 'onlytext', 'minsize' => '8'),
                            array('size' => '40', 'maxlength' => '35'));?> 
                </td>
                <td style="vertical-align: middle"><?php $doc->texto('IDENTIFIER') ?>: </td>
                <td style="vertical-align: middle">
                    <?php $view->input("cedula", 
                            "numeric", 
                            $doc->t('IDENTIFIER'),
                            array('required' => true, 'text' => 'numeric', 'norepeat' => 'val1', 'minsize' => '5'),
                            array('size' => '20', 'maxlength' => '15')); ?>
                </td>

            </tr>
            <tr>
                <td><?php $doc->texto('BORN_DATE') ?>: </td> 
                <td> 
                                <input type="date" name="born_date">                 
                </td>               
                <td><?php $doc->texto('MAIL') ?>: </td>
                <td>
                    <?php $view->input("email",
                            "text", $doc->t('MAIL'),
                            array('required' => true, 'text' => 'email', 'norepeat' => 'val1'),
                            array('size' => '45', 'maxlength' => '40')); ?>
                </td>                 
            </tr>
        </table>
    </fieldset>    
    <fieldset class="colorleyend" style="width: 90%">
        <legend class="colorleyendinto">Informacion de usuario</legend>
        <table cellspacing="10" style="width:100%; line-height: 20px" align="center" >
            <tr>
                <td style="vertical-align: top">Alias(*): </td>
                <td style="vertical-align: top">                        
                    <?php
                    $view->input("alias", 
                            "text", 
                            'Alias', 
                            array('required' => true, 'text' => 'alias', 'minsize' => '5', 'norepeat' => 'val1'), 
                            array('size' => '25', 'maxlength' => '20', 'style'=>'text-transform:uppercase;', 'id'=>'alias'));
                    ?>                        
                </td>
                <td style="vertical-align: top">Contrase&ntilde;a(*): </td>
                <td style="vertical-align: top">
                    <input id="pass" type="password" size="30" onkeyup="verificar2()" name="con" minsize="5" patt="val1" label="password" presence="val1" maxlength="16"/>
                </td>

            </tr>
            <tr>                
                <td>Perfil: </td>
                <td>
                    <select name="profile">
                        <?php foreach ($perfiles as $value) { ?>                                                    
                        <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
                        <?php } ?>
                    </select>                  
                </td>   
                <td style="vertical-align: top">Confirmar contrase&ntilde;a(*): </td>
                <td style="vertical-align: top">
                    <input id="passs" type="password" size="30" onkeyup="verificar()" name="concon" maxlength="16"/>
                </td>
            </tr>
        </table>
    </fieldset>            
        <button class="buscarButton" id="accpet" style="float: left;height: 40px; margin-left: 5%">CREAR USUARIO</button>
    </form>    
    <div id="loader" style="float: left; margin-left: 12px; display: none;">
        <img src="images/ajax-loader.gif"/> Procesando... 
    </div>
    <div style="clear: both"></div>
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    function verificar(){
        if($('#pass').val()==''&& $('#passs').val()!=''){
            $('#errormipas').remove();
            $('#passs').val('');
            $('#passs').after('<div id="errormipas" style="font-size: 12px; color: Red; font-weight: bold;">Debe digitar una nueva contrase&ntilde;a.</div>');
        }
    }
    function verificar2(){
        if($('#pass').val()==''&& $('#passs').val()!=''){
            $('#passs').val('');
        }else{
            $('#errormipas').remove();
        }
    }
    function message(mensaje,imagen){        
        $("#titlemesagge",window.parent.document).html("<strong>"+mensaje+"<strong/>");
        $("#iconmesagge",window.parent.document).html(" <img src='"+imagen+"'/>");       
        $("#barraf",window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf",window.parent.document).slideUp(1000).fadeOut(400);  
    }
    $(document).ready(function(){        
        $('#myform').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#accpet').attr('disabled', 'disabled');
                $("#accpet").addClass("buscarButtonDis");
                $("#accpet").removeClass("buscarButton");
                $('#loader').css('display', 'block');
                $('#alias').val($('#alias').val().toUpperCase());
                if(validates('myform')){                    
                    if($('#passs').val()==$('#pass').val()){
                        return true;
                    }else{
                        $('#loader').css('display', 'none');
                        $("#accpet").addClass("buscarButton");
                        $("#accpet").removeClass("buscarButtonDis");
                        $('#accpet').removeAttr('disabled');
                        $('#passs').after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">Las contrase&ntilde;as no coinciden</div>');
                        parent.message('Verifique los datos ingresados','images/iconosalerta/error.png');
                        return false;
                    }                    
                }else{                    
                    if($('#passs').val()==$('#pass').val()){
                        $('#loader').css('display', 'none');
                        $("#accpet").addClass("buscarButton");
                        $("#accpet").removeClass("buscarButtonDis");
                        $('#accpet').removeAttr('disabled');
                        return false;
                    }else{
                        $('#loader').css('display', 'none');
                        $("#accpet").addClass("buscarButton");
                        $("#accpet").removeClass("buscarButtonDis");
                        $('#accpet').removeAttr('disabled');
                        $('#passs').after('<div class="error_input" style="margin-top:8px !important;font-size: 12px; color: Red; font-weight: bold;">las contrase&ntilde;as no coinciden</div>');
                        return false;
                    }
                }

            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {
                $('#loader').css('display', 'none');
                $("#accpet").addClass("buscarButton");
                $("#accpet").removeClass("buscarButtonDis");
                $('#accpet').removeAttr('disabled');
                if(responseText.respuesta=='si'){                    
                    parent.createData(responseText.id,responseText.nombre,responseText.alias,
                            responseText.cedula,responseText.perfil, responseText.estado,
                            responseText.grupo,responseText.fecha,responseText.idcode,responseText.idverify);
                    parent.message('se ha creado un nuevo usuario','images/iconos_alerta/ok.png');
                    parent.$.fancybox.close();
                }else if(responseText.respuesta=='no'){
                    parent.message('No se ha podido crear el usuario','images/iconos_alerta/error.png');
                    pçarent.$.fancybox.close();
                }
            }
        });       

        $("#myform input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });
</script>

