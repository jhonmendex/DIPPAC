<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Inscripci&oacute;n de estudiantes: Verificaci&oacute de los datos</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">
            <p style="margin-top: 20px; font-size: medium">Por favor confirme la informaci&oacute;n del nuevo usuario antes de terminar el proceso de afiliacion.</p>      
            <p style="font-size: medium; margin-bottom: 0">Informaci&oacute;n del nuevo usuario:</p>
            <table style="width: 100%;" border="0">
                <tr>
                    <td width="220" class="describ"><strong>Nombre:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $usuario->getNombre() ?>
                    </td>
                </tr>
                <tr>
                    <td width="220" class="describ"><strong>Cedula:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $usuario->getCedula() ?>
                    </td>
                </tr>
                <tr>
                    <td width="220" class="describ"><strong>Fecha de nacimiento:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $usuario->getFechaNacimiento() ?>
                    </td>
                </tr>
                <tr>
                    <td class="describ"><strong>Informaci&oacute;n de contacto:</strong></td>
                    <td width="600" class="infodescrib">
                        <strong>Correo electronico:</strong> <?php echo $usuario->getEmail() ?></br>
                        <strong>Fax:</strong> <?php echo $usuario->getFax() == 0 ? NUll : $usuario->getFax() ?></br>
                        <strong>Telefono:</strong> <?php echo $usuario->getTelefono() == 0 ? NUll : $usuario->getTelefono() ?></br>
                        <strong>Celular:</strong> <?php echo $usuario->getMovil() == 0 ? NUll : $usuario->getMovil() ?></br>
                    </td>
                </tr>
                <tr>
                    <td class="describ"><strong>Direcci&oacute;n:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $usuario->getDireccion() ?>, barrio: <?php echo $barrio ?></br>
                        <?php echo $city_name . ", " . $departamento ?>

                    </td>
                </tr>
                <tr>
                    <td class="describ"><strong>Codigo de patrocinador:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $usuario->getIdPadre() ?>
                    </td>
                </tr>
                <tr>
                    <td class="describ"><strong>Nombre del patrocinador:</strong></td>
                    <td width="600" class="infodescrib">
                        <?php echo $soponsor_name ?>

                    </td>
                </tr>
                <tr>
                    <td class="describ"><strong>Informaci&oacute;n del beneficiario:</strong></td>
                    <td width="600" class="infodescrib">
                        <strong>Nombre:</strong> <?php echo $beneficiario->getNombre() ?></br>                
                        <strong>Cedula:</strong> <?php echo $beneficiario->getCedula() ?></br>
                        <strong>Parentesco:</strong> <?php echo $beneficiario->getParentesco() ?></br>
                        <strong>Fecha de nacimiento:</strong> <?php echo $beneficiario->getFechaNacimiento() ?></br>
                        <strong>Email:</strong> <?php echo $beneficiario->getEmail() ?></br>
                        <strong>Tel&eacute;fono:</strong> <?php echo $beneficiario->getTelefono() == 0 ? NUll : $beneficiario->getTelefono() ?></br>
                        <strong>Direcci&oacute;n:</strong> <?php echo $beneficiario->getDireccion() ?></br>                
                        <strong>Ciudad:</strong> <?php echo $city_nameBen . ", " . $departamentoBen ?></br>
                    </td>
                </tr>
            </table>    
            <p style="font-size: medium; margin-bottom: 0">La inscripci&oacute;n incluye lo siguiente:</p>
            <table class="table" cellspacing="0">
                <tr class="headall">
                    <th class="headinit">
                        Articulo
                    </th>
                    <th class="head">
                        Codigo
                    </th>

                    <th class="head" style="width: 90px;">
                        Precio del articulo
                    </th>   
                    <th class="head" style="width: 90px;">
                        Total
                    </th>


                </tr> 
                <tr class="class1">
                    <th class="init">
                        <?php echo $detail->getProducto()->getNombre(); ?>
                    </th>         

                    <th class="item">
                        <?php echo $detail->getProducto()->getReferencia(); ?>
                    </th>
                    <th class="item">
                        $<?php echo number_format($detail->getProducto()->getPrecio(), 0, ',', '.'); ?>
                    </th>

                    <th class="item">                    
                        $<?php echo number_format((($detail->getProducto()->getIva()
                                * $detail->getProducto()->getPrecio()) / 100) + $detail->getProducto()->getPrecio(), 0, ',', '.'); ?>
                    </th>

                </tr>
                <tr>
                    <th colspan="3" style="text-align: right; padding: 10px; font-size: 14px;" >
                        <strong>VALOR ANTES DE IVA</strong> 
                    </th>
                    <th colspan="1" class="init">
                        $<?php echo number_format($detail->getProducto()->getPrecio() * $detail->getCantidad(), 0, ',', '.'); ?>
                    </th>          

                </tr>
                <tr>
                    <th colspan="3" style="text-align: right; padding: 10px; font-size: 14px;" >
                        <strong>IVA</strong> 
                    </th>
                    <th colspan="1" class="init">
                        $<?php echo number_format(($detail->getProducto()->getIva() * $detail->getProducto()->getPrecio()) / 100, 0, ',', '.'); ?>
                    </th>          

                </tr>
                <tr>
                    <th colspan="3" style="text-align: right; padding: 10px; font-size: 14px;" >
                        <strong>TOTAL</strong> 
                    </th>
                    <th colspan="1" class="init">
                        $<?php echo number_format((($detail->getProducto()->getIva() * $detail->getProducto()->getPrecio()) /
                                100) + $detail->getProducto()->getPrecio(), 0, ',', '.'); ?>
                    </th>          

                </tr>
            </table>        
            <form action="index.php?controlador=Associated&accion=finishVinculate" method="post" id="formInscription">                       
                <button class="buscarButton" style="float: left;height: 40px;margin-left: 5%" id="finish"><?php $doc->texto('FINISH') ?> afiliaci&oacute;n</button>    
                <div id="loader" style="float: left;margin-left: auto; margin-right: auto; display: none">
                    <img src="images/ajax-loader.gif"/> Procesando...        
                </div>    
            </form>
            <form action="index.php?controlador=Associated&accion=formInscription" method="post" >
                <button class="buscarButton" style="float: left;height: 40px; margin-left: 5px" id="cancel"><?php $doc->texto('BACK') ?></button>
            </form>      
            <div style="clear: both"></div>     
        </div>
    </div>
</div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>        
    $(document).ready(function() {    
        $('#formInscription').ajaxForm({
            dataType: 'json',
            beforeSubmit: function() {
                $('#finish').attr('disabled', 'disabled');
                $("#finish").addClass("buscarButtonDis");
                $("#finish").removeClass("buscarButton");
                $('#cancel').attr('disabled', 'disabled');
                $("#cancel").addClass("buscarButtonDis");
                $("#cancel").removeClass("buscarButton");
                $('#loader').css('display', 'block');                
            },            
            success: function(responseText) {  
                /*
                $('#loader').css('display', 'none');
                $('#finish').removeAttr('disabled');
                $("#finish").addClass("buscarButton");
                $("#finish").removeClass("buscarButtonDis");
                $('#cancel').removeAttr('disabled');
                $("#cancel").addClass("buscarButton");
                $("#cancel").removeClass("buscarButtonDis");
                */
                window.location=responseText.url;                
            }
        });

    });
</script>
