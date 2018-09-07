<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div align="center">    
    <form action="index.php?controlador=Products&accion=updateCategoryAjax" method="POST" id="formCategoria">
        <fieldset class="colorleyend" style="width: 90%">
            <legend class="colorleyendinto">Editar Categoria</legend>
            <table cellspacing="5" border="0" style="width: 100%; line-height: 18px" align="center">
                <tr>
                    <td colspan="3" style="font-size: small">
                        A continuaci&oacute;n Actualice el nombre de la categoria.
                    </td>              
                </tr>
                <tr>
                    <td width="50%">Nombre Categoria: </td>              
                    <td width="50%">
                        <?php
                        $view->input("nombrecategoria", "text", "Nombre categoria", array('required' => true,
                            'text' => 'regular',
                            'minsize' => '3',
                            'norepeat' => 'val6',
                            'except' => $nombrecategoria),
                                array('maxlength' => '30',
                            'size' => '28',
                            'style' => 'text-transform:uppercase;',
                            'id' => 'nombrecat',
                            'value' => $nombrecategoria));
                        ?>  
                        <input type="hidden" name="idcategoria" value="<?php echo $idcategoria ?>"
                    </td>
                </tr>
            </table>
        </fieldset>
    </form>
    <button class="buscarButton" style="float: left;height: 40px; margin-left: 5%" id="finish">Editar<br> Categoria</button>          
    <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
        <img src="images/ajax-loader.gif"/> Procesando...        
    </div>
    <div style="clear: both"></div>
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    function message(mensaje, imagen) {
        $("#titlemesagge", window.parent.parent.document).html("<strong>" + mensaje + "<strong/>");
        $("#iconmesagge", window.parent.parent.document).html(" <img src='" + imagen + "'/>");
        $("#barraf", window.parent.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf", window.parent.parent.document).slideUp(1000).fadeOut(400);
    }
    $(document).ready(function() {
        $("#nombrecat").keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

        $('#finish').click(function() {
            $('#formCategoria').ajaxForm({
                dataType: 'json',
                beforeSubmit: function() {
                    $('#cancel').attr('disabled', 'disabled');
                    $("#cancel").addClass("buscarButtonDis");
                    $("#cancel").removeClass("buscarButton");
                    $('#finish').attr('disabled', 'disabled');
                    $("#finish").addClass("buscarButtonDis");
                    $("#finish").removeClass("buscarButton");
                    $('#loader').css('display', 'block');
                    if (validates("formCategoria")) {
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
                uploadProgress: function(event, position, total, percentComplete) {
                },
                success: function(responseText) {
                    $('#loader').css('display', 'none');
                    $('#finish').removeAttr('disabled');
                    $('#cancel').removeAttr('disabled');
                    if (responseText.respuesta == 'si') {
                        parent.updatedata(responseText.id, responseText.nombre);
                        $("#categorias option[value='" + responseText.id + "']", window.parent.parent.document).html(responseText.nombre);
                        parent.parent.message('Se ha editado la categoria', 'images/iconos_alerta/ok.png');
                        parent.$.fancybox.close();
                    } else if (responseText.respuesta == 'no') {
                        parent.parent.message('No se ha podido editar la categoria', 'images/iconos_alerta/error.png');
                        parent.$.fancybox.close();
                    }
                }
            }).submit();

        });
        $('#cancel').click(function() {
            parent.$.fancybox.close();
        });
        
        $("#formCategoria input").focus(function(){
            $(this).css("background-color","#FFF");
            $(this).nextAll().remove();
        });
    });
</script>