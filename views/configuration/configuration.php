<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Configuraci&oacute;n general</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div align="center">                         
            <form action="index.php?controlador=Configuration&accion=updateData" method="POST" id="formConfig"> 
            <fieldset class="colorleyend" style="width: 90%;">
                <legend class="colorleyendinto">Informaci&oacute;n basica de la empresa</legend>
                <table cellspacing="10" style="width: 100%;" align="center">
                    <tr>
                        <td style="font-size: small; line-height: normal" colspan="4">
                        A continuaci&oacute;n diligencie la informaci&oacute;n de la empresa, estos datos son necesarios para los envios de correos y descarga de documentos del aplicativo, los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
                    </tr>
                    <tr>
                        <td style="vertical-align: top"><?php $doc->texto('FULL_NAME') ?>: </td>
                        <td style="vertical-align: top">
                            <?php
                            $view->input("company",
                                    "text",
                                    $doc->t('FULL_NAME'), array('required' => true,
                                'text' => 'regular',
                                'minsize' => '5'), array('size' => '40',
                                'maxlength' => '35',
                                'value'=>trim($settigs["company"])));
                            ?> 
                        </td>
                        <td style="vertical-align: top">Nit(*): </td>
                        <td style="vertical-align: top">
                            <?php
                            $view->input("nit", 
                                    "text", 
                                    "Nit", 
                                    array('required' => true, 'text' => 'regular', 'minsize' => '10'), 
                                    array('size' => '20', 'maxlength' => '15', 'value'=>trim($settigs["nit"])));
                            ?>
                        </td>

                    </tr>
                    <tr>                        
                        <td><?php $doc->texto('MAIL') ?>: </td>
                        <td>
                            <?php
                            $view->input("mail", "text", $doc->t('MAIL'), 
                                    array('required' => true, 'text' => 'email'),
                                    array('size' => '45', 'maxlength' => '40','value'=>trim($settigs["mail"])));
                            ?>
                        </td>
                        <td style="vertical-align: top"><?php $doc->texto('PHONE') ?>(*): </td>
                        <td style="vertical-align: top">
                            <?php
                            $view->input("telefono",
                                    "text",
                                    $doc->t('PHONE'), 
                                    array('required' => true,
                                'text' => 'regular',
                                'minsize' => '5'), array('size' => '16',
                                'maxlength' => '15',
                                'value'=>trim($settigs["telefono"])));
                            ?> 
                        </td>
                        
                    </tr>
                    <tr>
                        
                        <td style="vertical-align: top"><?php $doc->texto('ADDRESS') ?>: </td>
                        <td style="vertical-align: top">
                            <?php
                            $view->input("direccion", 
                                    "text", 
                                    $doc->t('ADDRESS'), 
                                    array('required' => true, 'text' => 'regular', 'minsize' => '10'), 
                                    array('size' => '35', 'maxlength' => '35', 'value'=>trim($settigs["direccion"])));
                            ?>
                        </td>
                        <td></td> 
                        <td>
                        </td>
                    </tr>
                </table>
            </fieldset>                  
            <fieldset class="colorleyend" style="width: 90%;">
                <legend class="colorleyendinto">Informaci&oacute;n del plan de compensaci&oacute;n</legend>
                <table cellspacing="10"  style="width:100%;" align="center">
                    <tr>
                        <td style="font-size: small; line-height: normal" colspan="4">
                            A continuaci&oacute;n diligencie la informaci&oacute;n referente a los puntos, al cambiar el valor del punto, se actualizar&aacute;n                            
                        los puntos que tiene cada producto inmediatamente y se vera reflejado en que se hagan apenas guarde el valor nuevo del punto, 
                        el limite minimo de puntos se aplicara la proxima vez que se generen las comisiones,los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
                    </tr>
                    <tr>
                        <td>Valor punto(*): </td>
                        <td>
                            <?php
                            $view->input("pointvalue", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '8', 'maxlength' => '6', 'value'=>trim($settigs["pointvalue"])));
                            ?>                 
                        </td>
                        <td>Limite minimo de puntos para comisionar(*): </td>
                        <td>
                            <?php
                            $view->input("minpoints", 
                                    "numeric", 
                                   "Limite minimo de puntos", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '8', 'maxlength' => '6', 'value'=>trim($settigs["minpoints"])));
                            ?>                         
                        </td>
                    </tr> 
                    <tr>
                        <td style="font-size: small; line-height: normal" colspan="4">
                            A continuaci&oacute;n diligencie la informaci&oacute;n referente a los porcentajes que se repartiran por nivel
                            a los estudiantes de la utilidad de cada producto, al actualizar los valores, las siguientes facturas de estudiantes que se generen empezaran
                            a calcular las utilidades basadas en los nuevos valores, 
                            los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
                    </tr>
                    
                    <tr>
                        <td colspan="4">Nivel 0(*): <?php
                            $view->input("nivel0", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '4', 'maxlength' => '2', 'value'=>trim($settigs["nivel0"])));
                            ?>% </td>
                    </tr><tr>
                        <td colspan="4">Nivel 1(*): <?php
                            $view->input("nivel1", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '4', 'maxlength' => '2', 'value'=>trim($settigs["nivel1"])));
                            ?>% </td>
                    </tr><tr>                                                 
                        <td colspan="4">Nivel 2(*): <?php
                            $view->input("nivel2", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '4', 'maxlength' => '2', 'value'=>trim($settigs["nivel2"])));
                            ?>% </td>
                        </tr><tr>
                        <td colspan="4">Nivel 3(*): <?php
                            $view->input("nivel3", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '4', 'maxlength' => '2', 'value'=>trim($settigs["nivel3"])));
                            ?>% </td>
                    </tr><tr>
                        <td colspan="4">Nivel 4 en adelante(*): <?php
                            $view->input("niveln", 
                                    "numeric", 
                                    "Valor punto", 
                                    array('required' => true, 'text' => 'numeric', 'minsize' => '1'), 
                                    array('size' => '4', 'maxlength' => '2', 'value'=>trim($settigs["niveln"])));
                            ?>% </td>
                    </tr>  
                </table>
            </fieldset>        
            <button class="buscarButton" style="float: left;height: 40px;margin-left: 5%" id="finish">Guardar</button>    
            <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
                <img src="images/ajax-loader.gif"/> Procesando...        
            </div>    
        </form>            
            <div style="clear: both"></div> 
        </div> 
    </div>
</div>  
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>        
    $(document).ready(function() {                               
        
        $("#formConfig input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
                 
        $('#formConfig').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#finish').attr('disabled', 'disabled');
                $("#finish").addClass("buscarButtonDis");
                $("#finish").removeClass("buscarButton");
                $('#cancel').attr('disabled', 'disabled');
                $("#cancel").addClass("buscarButtonDis");
                $("#cancel").removeClass("buscarButton");
                $('#loader').css('display', 'block');
                if (validates("formConfig")) {
                    return true;
                } else {
                    $('#loader').css('display', 'none');
                    $('#finish').removeAttr('disabled');
                    $("#finish").addClass("buscarButton");
                    $("#finish").removeClass("buscarButtonDis");
                    $('#cancel').removeAttr('disabled');
                    $("#cancel").addClass("buscarButton");
                    $("#cancel").removeClass("buscarButtonDis");
                    return false;
                }
            },            
            success: function(responseText) {   
                    $('#loader').css('display', 'none');
                    $('#finish').removeAttr('disabled');
                    $("#finish").addClass("buscarButton");
                    $("#finish").removeClass("buscarButtonDis");
                    $('#cancel').removeAttr('disabled');
                    $("#cancel").addClass("buscarButton");
                    $("#cancel").removeClass("buscarButtonDis");
                    message("Se han actualizado los datos correctamente", "images/iconos_alerta/ok.png");               
            }
        });
    });
</script>
