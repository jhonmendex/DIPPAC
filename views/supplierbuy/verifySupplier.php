<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div align="center">
    <?php $view->startForm("index.php?controlador=SupplierBuy&accion=verifyExistSupplier", "formWarehouse"); ?>    
    <fieldset class="colorleyend" style="width: 90%">
        <legend class="colorleyendinto">Agregar proveedor</legend>
        <table cellspacing="10" border="0" style="width: 100%;" align="center">
            <tr>
                <td>Nit: </td>              
                <td>
                    <?php $view->input("nit_supplier",
                            "numeric", 
                            "Nit", 
                            array('required' => true, 'text' => 'numeric', 'minsize'=>'5'),
                            array('size' => '15','maxlength'=>'13')); ?>                    
                </td>
            </tr>     
        </table>
    </fieldset>     
    <button class="buscarButton">Aceptar</button>
     <?php $view->endForm(); ?>    
</div> 
<script> 
    function message(mensaje,imagen){        
        $("#titlemesagge",window.parent.document).html("<strong>"+mensaje+"<strong/>");
        $("#iconmesagge",window.parent.document).html(" <img src='"+imagen+"'/>");       
        $("#barraf",window.parent.document).slideDown(1000).delay(3000).fadeIn(400);
        $("#barraf",window.parent.document).slideUp(1000).fadeOut(400);  
    }
</script>

