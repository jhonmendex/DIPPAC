<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<form id="myform" action="index.php?controlador=Novinculado&accion=valUser" method="post">
    <fieldset class="colorleyend" style="width: 95%">
        <legend class="colorleyendinto">Restablecer contrase&ntilde;a</legend>
        <table cellspacing="6" style="width:100%; line-height: 20px" align="center">
            <tr>
                <td style="text-align: justify;font-size: 12px; margin-bottom: 12px" colspan="2">
                    Por favor digite el alias de su usuario y le enviaremos al correo asociado a su cuenta una nueva contrase&ntilde;a.
                </td>                
            </tr>
            <tr>
                <td style="vertical-align: middle">                        
                    <?php
                    $view->input("aliasUser", 
                            "text",
                            'Alias',
                            array('required' => true,
                                'text' => 'alias',
                                'minsize' => '5'), 
                            array('size' => '25', 
                                'maxlength' => '20',
                                 'placeholder' => 'Alias',
                                'style' => 'margin-top:10px;text-transform:uppercase;',
                                'id' => 'alias'));
                    ?>
                </td>
            </tr>            
        </table>
    </fieldset>
    <button id="accpet" style="float: left;margin-left: 12px" class="buscarButton">Aceptar</button>                                    
</form>
<div id="loader" style="float: left; margin-left: 12px; display: none;">
    <img src="images/ajax-loader.gif"/>
</div>
<div style="clear: both"></div>    
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    function message(mensaje, imagen) {
        $("#titlemesagge", window.parent.document).html("<strong>" + mensaje + "<strong/>");
        $("#iconmesagge", window.parent.document).html(" <img src='" + imagen + "'/>");
        $("#barraf", window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf", window.parent.document).slideUp(1000).fadeOut(400);
    }
    $(document).ready(function() {        
        $('#myform').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#accpet').attr('disabled', 'disabled');
                $("#finish").attr('disabled', 'disabled');
                $('#loader').css('display', 'block');                
                $('#alias').val($('#alias').val().toUpperCase());                
                if (validates('myform')) {
                    return true;
                } else {
                    $('#loader').css('display', 'none');
                    $('#accpet').removeAttr('disabled');
                    $("#finish").removeAttr('disabled');                    
                    return false;
                }
            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {
                $('#loader').css('display', 'none');
                $('#accpet').removeAttr('disabled');
                $("#finish").removeAttr('disabled');
                if (responseText.result == 'error') {                    
                    parent.message('No se ha podido restablecer la contrase&ntilde;a', 'images/iconos_alerta/error.png');                    
                    parent.$.fancybox.close();
                }else {                    
                    parent.message('Se ha enviado una nueva contrase&ntilde;a a su correo', 'images/iconos_alerta/ok.png');
                    parent.$.fancybox.close();
                }
            }
        });
        $("#myform input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });
</script>