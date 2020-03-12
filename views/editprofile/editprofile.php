<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-main">Mi perfil</td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 15px"> 
            <div align="center" >
                <table border="0" style="width: 90%; margin-top: 20px"> 
                <tr>
                    <td style="font-size: small">
                        A continuaci&oacute;n actualice su informaci&oacute;n personal y de envio, los campos que tienen asterisco "(*)" son obligatorios.
                    </td>              
                </tr>
            </table>   
                <form action="index.php?controlador=Profile&accion=updateprofile" method="POST" id="formUpdate">                     
                <fieldset class="colorleyend" style="width: 90%">
                    <legend class="colorleyendinto"><?php $doc->texto('BASIC_INFORMATION') ?></legend>
                    <div class="form-group">
                        <label><?php $doc->texto('FULL_NAME') ?>: </label>
                         <?php $view->input("full_name",
                                        "text", $doc->t('FULL_NAME'), 
                                        array('required' => true, 'text' => 'onlytext', 'minsize' => '8'), 
                                        array('size' => '40', 'maxlength' => '35','value' => $usuariop->getNombre())); ?>  
                    </div>
                    <div class="form-group">
                        <label><?php $doc->texto('IDENTIFIER') ?>: </label>
                         <?php $view->input("cedula",
                                        "text",
                                        $doc->t('IDENTIFIER'), 
                                        array('required' => true, 'text' => 'numeric', 'minsize' => '5'), 
                                        array('size' => '20', 'maxlength' => '15','value' => $usuariop->getCedula())); ?>
                    </div>
                     <div class="form-group">
                        <label><?php $doc->texto('BORN_DATE') ?>: </label>
                          <?php $view->input("born_date",
                                        "calendar", 
                                        $doc->t('BORN_DATE'), 
                                        array('required' => true), 
                                        array('readonly' => 'readonly',
                                                'midate' => 1920,
                                                'madate' => ((int) date("Y")) - 18,
                                                'value' => $usuariop->getFechaNacimiento())); ?>
                    </div>
                    <div class="form-group">
                        <label><?php $doc->texto('MAIL') ?>: </label>
                           <?php $view->input("email", 
                                        "text", $doc->t('MAIL'),
                                        array('required' => true, 'text' => 'email', 'norepeat' => 'val1','except'=>$usuariop->getEmail()), 
                                        array('size' => '45', 'maxlength' => '40','value' => $usuariop->getEmail())); ?>
                    </div>
                </fieldset>
                <fieldset class="colorleyend" style="width: 90%">
                    <legend class="colorleyendinto"><?php $doc->texto('SEND_INFORMATION') ?></legend>
                      <div class="form-group">
                        <label><?php $doc->texto('PHONE') ?>:</label>
                           <?php $view->input("phone",
                                        "numeric", $doc->t('PHONE'),
                                        array('text' => 'numeric', 'minsize' => '7'), 
                                        array('size' => '12',
                                        'maxlength' => '10',
                                        'value' => ($usuariop->getTelefono() == 0) ? '' : $usuariop->getTelefono())); ?>  
                      </div>
                       <div class="form-group">
                        <label><?php $doc->texto('MOVIL') ?>:</label>
                          <?php $view->input("movil",
                                        "numeric", $doc->t('MOVIL'), 
                                        array('text' => 'numeric', 'minsize' => '10'), 
                                        array('size' => '12',
                                        'maxlength' => '10', 'value' => ($usuariop->getMovil() == 0) ? '' : $usuariop->getMovil())); ?> 
                      </div>
                       <div class="form-group">
                        <label><?php $doc->texto('STADE') ?>:</label>
                          <?php echo $deps; ?>
                      </div>
                       <div class="form-group">
                        <label><?php $doc->texto('CITY') ?>:</label>
                         <div id="resCid"><?php echo $cids; ?></div>
                      </div>
                      <div class="form-group">
                        <label><?php $doc->texto('ADDRESS') ?>: </label>
                         <?php $view->input("address", 
                                        "text", 
                                        $doc->t('ADDRESS'),
                                        array('required' => true, 'text' => 'address'),
                                        array('size' => '50',
                                        'maxlength' => '50', 
                                        'minsize' => '10','value' => $usuariop->getDireccion())); ?>
                      </div>
                       <div class="form-group">
                        <label><?php $doc->texto('FAX') ?>:</label>
                          <?php
                                $view->input("fax", 
                                        "numeric", 
                                        $doc->t('FAX'),
                                        array('text' => 'numeric', 'minsize' => '7'), 
                                        array('size' => '12', 
                                        'maxlength' => '10',
                                            'value' => ($usuariop->getFax() == 0) ? '' : $usuariop->getFax()));
                                ?> 
                      </div> 
                </fieldset>     
            <div class="mitadboton">
               <button class="buscarButton" id="accpet" style="float: left;height: 40px; margin-left: 5%">Actualizar<br>Informaci&oacute;n</button>  
                    <div id="loader" style="float: left; margin-left: 12px; display: none;">
                        <img src="images/ajax-loader.gif"/> Procesando...
                    </div>
            </div>                        
            <div style="clear: both"></div>
            </form>
            </div> 
        </div> 
    </div> 
</div> 
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    $(document).ready(function() {     
        $('#formUpdate').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#accpet').attr('disabled', 'disabled');
                $("#accpet").addClass("buscarButtonDis");
                $("#accpet").removeClass("buscarButton");
                $('#loader').css('display', 'block');                
                if(validates('formUpdate')){
                    return true;
                }else{
                    $('#loader').css('display', 'none');
                    $("#accpet").addClass("buscarButton");
                    $("#accpet").removeClass("buscarButtonDis");
                    $('#accpet').removeAttr('disabled');
                    return false;
                }

            },
            uploadProgress: function(event, position, total, percentComplete) {
            },
            success: function(responseText) {                
                if(responseText.respuesta=='si'){                    
                    window.location="index.php?controlador=Profile&message=ok";                  
                }else if(responseText.respuesta=='no'){
                    $('#loader').css('display', 'none');
                    $("#accpet").addClass("buscarButton");
                    $("#accpet").removeClass("buscarButtonDis");
                    $('#accpet').removeAttr('disabled');
                    parent.message('No se ha podido actualizar los datos del usuario','images/iconos_alerta/error.png');                    
                }
            }
        });
        
        $("#departamentos").change(function() {              
            var ajaxOpts = {
                type: "get",
                url: "index.php",
                data: "&controlador=Profile&accion=ajaxCiudades&departamento=" + $("#departamentos").val(),
                success: function(data) {							
                    $('#resCid').html(data);
                }                
            };
            $.ajax(ajaxOpts);
        });
        $("#departamentos").val(<?php echo $tdepto ?>);
        $("#ciudades").val(<?php echo $tciu ?>);        
<?php if ($message != null) { ?>
            message('<?php echo $message ?>','<?php echo $icon_message ?>');
<?php } ?>
    
        $("#formUpdate input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
        
        $('input.onepic').click(function(){
            $("[name='year']").val(<?php echo $ano2 ?>);   
            $("[name='month']").val(<?php echo $mes2 ?>); 
            var ano =  $("[name='year']").val();
            var mes =  $("[name='month']").val();
            var dia =<?php echo $dia2 ?>;
            var diamax =<?php echo $dia ?>;
            var mesmax =<?php echo $mes ?>;
            var anomax =<?php echo $ano ?>; 
            var $ttd = $('td.date'); 
               if(ano<anomax){
                    $ttd.each(function() { 
                            if($.trim($(this).html())==dia){                    
                                $(this).addClass("chosen");
                            }
                     });
                }else if(ano==anomax){
                    if(mes==mesmax){
                        $ttd.each(function() { 
                            if($.trim($(this).html())==dia){                    
                                $(this).addClass("chosen");
                            }else if($.trim($(this).html())>diamax){                    
                                $(this).css("color","#555555");
                                $(this).css("cursor","default"); 
                                $(this).unbind();
                           }
                        });
                    }else if(mes>mesmax){                            
                        $ttd.each(function() {                                                                
                            $(this).css("color","#555555");
                            $(this).css("cursor","default"); 
                            $(this).unbind();              
                        }); 
                    }
                }else if(ano>anomax){                            
                    $ttd.each(function() {                                                            
                        $(this).css("color","#555555");
                        $(this).css("cursor","default"); 
                        $(this).unbind();               
                    }); 
                }                            
            $("select[name='year']").change(function(){                
                var ano =  $(this).val();
                var mes =  $("[name='month']").val();
                var diamax =<?php echo $dia ?>;
                var mesmax =<?php echo $mes ?>;
                var anomax =<?php echo $ano ?>; 
                var $ttd = $('td.date');
                if(ano<anomax){
                    $ttd.each(function() {                                                                           
                        $(this).css("color","#000000");
                        $(this).css("cursor","pointer");                                                    
                    });
                }else if(ano==anomax){
                    if(mes<mesmax){                         
                        $ttd.each(function() {  
                            $(this).css("color","#000000");
                            $(this).css("cursor","pointer"); 
                        });
                    }else if(mes==mesmax){
                        $ttd.each(function() { 
                            if($.trim($(this).html())>diamax){                    
                                $(this).css("color","#555555");
                                $(this).css("cursor","default"); 
                                $(this).unbind();
                            }else{
                                $(this).css("color","#000000");
                                $(this).css("cursor","pointer");   
                            }
                        });
                    }else if(mes>mesmax){                            
                        $ttd.each(function() {                                                                
                            $(this).css("color","#555555");
                            $(this).css("cursor","default"); 
                            $(this).unbind();              
                        }); 
                    }
                }else if(ano>anomax){                            
                    $ttd.each(function() {                                                            
                        $(this).css("color","#555555");
                        $(this).css("cursor","default"); 
                        $(this).unbind();               
                    }); 
                }
            });
            $("[name='month']").change(function(){
                var ano =  $("[name='year']").val();
                var mes =  $("[name='month']").val();
                var diamax =<?php echo $dia ?>;
                var mesmax =<?php echo $mes ?>;
                var anomax =<?php echo $ano ?>; 
                var $ttd = $('td.date');
                if(ano<anomax){
                    $ttd.each(function() { 
                        $(this).css("color","#000000");
                        $(this).css("cursor","pointer");
                    });
                }else if(ano==anomax){
                    if(mes<mesmax){
                        $ttd.each(function() { 
                            $(this).css("color","#000000");
                            $(this).css("cursor","pointer"); 
                        });
                    }else if(mes==mesmax){
                        $ttd.each(function() { 
                            if($.trim($(this).html())>diamax){                    
                                $(this).css("color","#555555");
                                $(this).css("cursor","default"); 
                                $(this).unbind();
                            }else{
                                $(this).css("color","#000000");
                                $(this).css("cursor","pointer");   
                            }
                        });
                    }else if(mes>mesmax){                            
                        $ttd.each(function() {                                    
                            $(this).css("color","#555555");
                            $(this).css("cursor","default"); 
                            $(this).unbind();               
                        }); 
                    }
                }else if(ano>anomax){                            
                    $ttd.each(function() {                                    
                        $(this).css("color","#555555");
                        $(this).css("cursor","default"); 
                        $(this).unbind();               
                    }); 
                }
            });
            $("#formUpdate input").not(".onepic").click(function(){
                $(".close").click();
            });           
        });    
    });
    
</script>