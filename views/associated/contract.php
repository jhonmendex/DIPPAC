<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50">
            <table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap">
                <tbody>
                    <tr>
                        <td id="fancybox-title-float-main">
                            Inscripci&oacute;n de estudiantes: 
                        </td> 
                    </tr>
                </tbody>
            </table>
        </div>
<div class="container" style="margin-bottom: 20px; margin-top: 10px">  
    <strong><p><?php $doc->texto('ASSOCIATE') ?>:</p></strong>

    <?php $doc->texto('ADVANTAGES_ASSOCIATE') ?>:
    <ul style="margin-left: 50px;">            
        <li style="color: green;"><span style="color: #000;"><?php $doc->texto('ADVANTAGE_1') ?></span></li>
        <li style="color: green;"><span style="color: #000;"><?php $doc->texto('ADVANTAGE_2') ?></span></li>
        <li style="color: green;"><span style="color: #000;"><?php $doc->texto('ADVANTAGE_3') ?></span></li>
        <li style="color: green;"><span style="color: #000;"><?php $doc->texto('ADVANTAGE_4') ?></span></li>
    </ul></br>
    <div style="float: left;margin-right: 5px;">
        <?php $doc->texto('SPONSOR_CODE') ?>: </div>
    <div style="float: left;margin-right: 5px;">
        <?php if($perfil=="Superadministrador"){ ?>
    <input name="id_user"                                                              
           id="code" 
           size="7"
           maxlength="5" 
           type="text"
           value="<?php echo $id ?>"                                                   
           onkeypress="return validar(event)"/>
    <?php }else{?>
     <input name="user"                                                                          
           size="7"
           maxlength="5" 
           type="text"
           readonly="readonly" 
           disabled="disabled" 
           value="<?php echo $id ?>"                                                   
           onkeypress="return validar(event)"
           style="cursor:default; background: #c9d3e8"/>
     <input type="hidden" name="id_user" id="code" value="<?php echo $id ?>" />
    <?php } ?>
    </div>
    <div style="float: left;margin-left: 5px;">
    <button id="see" class="buscarButton" style="float: left;margin-right: 5px; width: 60px;margin-top: 0px">
        <?php $doc->texto('SEE') ?>
    </button>
    <div id="resultado" style="float: left;margin-right: 5px;"><strong><?php echo $nameSpon ?></strong></div></br> 
    </div>
    <div style="clear: both"></div>
  <?php if($perfil=="Superadministrador"){ ?>
       <?php $doc->texto('CONTRACT') ?>: </br>
        <div id="content_1" class="contentscroll">
            <?php $doc->texto('CONTRACT_CONTENT') ?>
        </div>
        <div>
            <input type="checkbox" name="accept"/>
            <?php $doc->texto('ACCEPT_CONTRACT') ?>
        </div>
        <button class="buscarButton" style="float: left;height: 40px; margin-top: 20px" id="next"><?php $doc->texto('CONTINUE') ?></button>  
        <?php } else{if ($verifynet == false ) { ?>
        <?php $doc->texto('CONTRACT') ?>: </br>
        <div id="content_1" class="contentscroll">
            <?php $doc->texto('CONTRACT_CONTENT') ?>
        </div>  
        <div> 
            <input type="checkbox" name="accept"/>
            <?php $doc->texto('ACCEPT_CONTRACT') ?>
        </div>
        <button class="buscarButton" style="float: left;height: 40px; margin-top: 20px" id="next"><?php $doc->texto('CONTINUE') ?></button>  
      <?php  } else{ ?>
        <h1>Has alcanzado tu máximo de afiliados</h1>
       <?php } } ?>    
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none; margin-top: 20px">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
    <div id="message_error"></div>
</div>
        </div>
    </div>
    <script>        
    $(document).ready(function() { 



        $("#next").click(function() {  
            $(".error_input").remove();
            if($('input[name=accept]').is(':checked')){   
                if($("#code").val()!=0){
                var ajaxOpts = {
                    dataType: 'json',
                    type: "get",
                    url: "index.php",
                    data: "&controlador=Associated&accion=existSponsor&sponsor=" + $("#code").val(),
                    beforeSend: function( xhr ) {
                        $('#next').attr('disabled', 'disabled');
                        $("#next").addClass("buscarButtonDis");
                        $("#next").removeClass("buscarButton");
                        $('#loader').css('display', 'block');
                    },
                    success: function(data) {	
                        if(data.respuesta=="si"){
                            window.location='index.php?controlador=Associated&accion=formInscription&sponsor=' + $("#code").val()
                        }else{    
                            $('#next').removeAttr('disabled');
                            $("#next").addClass("buscarButton");
                            $("#next").removeClass("buscarButtonDis");
                            $('#loader').css('display', 'none');
                            message(data.mensaje,'images/iconos_alerta/warning.png');
                        }                        
                    }                
                };
                $.ajax(ajaxOpts);
                }else{
                   message('Debe seleccionar un patrocinador','images/iconos_alerta/warning.png'); 
                    $("#code").after('<div class="error_input" style="font-size: 12px; color: Red; font-weight: bold;">Codigo de patrocinador no es valido</div>');
                }
            }else{                                
                message('Debe aceptar los terminos y condiciones para continuar','images/iconos_alerta/warning.png');
            }            
        });    
        $("#see").click(function() { 
            $(".error_input").remove();
            var ajaxOpts = {
                type: "get",
                url: "index.php",
                data: "&controlador=Associated&accion=ajaxName&sponsor=" + $("#code").val(),
                success: function(data) {							
                    $('#resultado').html("<strong>"+data+"</strong>");
                }                
            };
            $.ajax(ajaxOpts);
        });   
        
        //$("#download").click(function() {                     
         ///   window.location="index.php?controlador=Associated&accion=downcontract";                
        //});           
    });
</script>
    <script>
        (function($){
            $(window).load(function(){
                $("#content_1").mCustomScrollbar({
                    autoHideScrollbar:true,
                    theme:"light-thin"
                });
            });
        })(jQuery);
    </script>