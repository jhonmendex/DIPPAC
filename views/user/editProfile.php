<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div align="center">    
    <form id="myform" action="index.php?controlador=ManageUsers&accion=updateProfile" method="post">
        <fieldset class="colorleyend" style="width: 90%">
            <legend class="colorleyendinto">Cambiar perfil de <?php echo $usuario['nombre'] ?></legend>
            <table cellspacing="10" style="width:100%; line-height: 20px" align="center">
                <tr>
                <td colspan="2" style="font-size: small; line-height: normal !important">
                    A continuaci&oacute;n actualice el perfil de usuario seleccionado.
                </td>              
            </tr>
                <tr>
                    <td style="vertical-align: middle">Perfil de usuario: </td>
                    <td style="vertical-align: middle">                        
                        <select name="perfil" id="perfiles">
                            <?php foreach ($perfiles as $value) { ?>
                                <option value="<?php echo $value['id'] ?>"><?php echo $value['nombre'] ?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>                                   
        </fieldset>                     
        <input type="hidden" name="idusuario" value="<?php echo $usuario['id'] ?>" />
        <button class="buscarButton" id="accpet" style="float: left;height: 40px; margin-left: 5%">Actualizar perfil</button>   
    </form>    
    <div id="loader" style="float: left; margin-left: 12px; display: none;">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>        
    <div style="clear: both"></div>             
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    $(document).ready(function(){    
        $("#bottoncancel").click(function(){
            parent.$.fancybox.close();
        });
        $("#perfiles").val("<?php echo $usuario['idperfil'] ?>");    
        $('#myform').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#accpet').attr('disabled', 'disabled');
                $("#accpet").addClass("buscarButtonDis");
                $("#accpet").removeClass("buscarButton");
                $('#loader').css('display', 'block');                
            },
            success: function(responseText) {
                $('#loader').css('display', 'none');
                $("#accpet").addClass("buscarButton");
                $("#accpet").removeClass("buscarButtonDis");
                $('#accpet').removeAttr('disabled');
                if(responseText.respuesta=='si'){    
                    parent.updatedata2(responseText.id,responseText.perfil);
                    parent.message('se ha actualizado el perfil del usuario','images/iconos_alerta/ok.png'); 
                    parent.$.fancybox.close();
                }else if(responseText.respuesta=='no'){
                    parent.message('No se ha podido actualizar el perfil del usuario','images/iconos_alerta/error.png');                    
                }
            }
        });
        $("#formInscription input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });
</script>