<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="main">
    <div class="maxcontent" id="content">
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Inscripci&oacute;n de estudiantes: Orden de pedido</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">
            <table width="97%" cellspacing="0" cellpadding="2" border="0" bgcolor="#369808">
                <tbody><tr>
                    <td align="center">
                        <table width="97%">
                            <tbody><tr>
                                <td>
                                    <p class="text2"></p>
                                </td>
                            </tr>
                        </tbody></table> 
                        <table width="97%" cellspacing="1" cellpadding="0" border="0" bgcolor="#48598a">
                            <tbody><tr bgcolor="#ffffff">
                                <td>
                                    <table width="100%" cellspacing="0" cellpadding="6" border="0">
                                        <tbody><tr>
                                            <td align="left" width="70%" valign="top">
                                                <p>Apreciable <b><?php echo $user->getNombre(); ?></b></p><p>Orden número: <b><?php echo $facturaNum; ?></b></p><p>Gracias
                                                por afiliarce en REDSOL COLOMBIA. </br>
                                            </p><p>Atentamente
                                        </p><p>Tu equipo REDSOL
                                    </p><table align="center" width="95%" border="0">
                                    <tbody><tr>
                                        <td>
                                            <table align="left" width="75%">
                                                <tbody><tr>
                                                    <td width="35%">Nombre</td>
                                                    <td><b><?php echo $user->getNombre(); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Estudiante No.</td>
                                                    <td><b><?php echo $user->getId(); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Orden No.</td>
                                                    <td><b><?php echo $facturaNum; ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Fecha</td>
                                                    <td><b><?php echo date("d-m-Y"); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Alias</td>
                                                    <td><b><?php echo $user->getAlias(); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Password</td>
                                                    <td><b><?php echo $user->getPassword(); ?></b></td>
                                                </tr>
                                                <tr>
                                                    <td>Patrocinador</td>
                                                    <td><b><?php echo $sponsor; ?></b></td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width="100%" cellspacing="0" style="text-align: center;">
                                                <tbody><tr class="headall">
                                                    <th class="headinit" style="width: 60px;">Cantidad</th>
                                                    <th class="head">Articulo</th>
                                                    <th class="head" style="width: 95px;">Código</th>
                                                    <th class="head">Precio</th>
                                                    <th class="head" style="width: 50px;">total</th>
                                                </tr>
                                                <tr class="class1">
                                                    <th class="init">
                                                        <?php echo $detalle->getCantidad(); ?>
                                                    </th>
                                                    <th class="item">
                                                        <?php echo $detalle->getProducto()->getNombre(); ?>
                                                    </th>
                                                    <th class="item">
                                                        <?php echo $detalle->getProducto()->getReferencia(); ?>
                                                    </th>
                                                    <th class="item">
                                                        $<?php echo number_format($subtotal + $iva, 0, ',', '.'); ?>
                                                    </th>
                                                    <th class="item">
                                                        $<?php echo number_format($subtotal + $iva, 0, ',', '.'); ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: right; padding: 10px; font-size: 14px;" >
                                                        <strong>PRECIO ANTES DE IVA</strong>
                                                    </th>
                                                    <th class="init"> $<?php echo number_format($subtotal, 0, ',', '.'); ?></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4" style="text-align: right; padding: 10px; font-size: 14px;" >
                                                        <strong>IVA</strong>
                                                        <th class="init"> $<?php echo number_format($iva, 0, ',', '.'); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4" style="text-align: right; padding: 10px; font-size: 14px;" >
                                                            <strong>TOTAL</strong>
                                                            <?php if ($iva != 0) { ?>
                                                            <th class="init"> $<?php echo number_format($subtotal + $iva, 0, ',', '.'); ?></th>
                                                            <?php } else { ?>
                                                            <th class="init"> $<?php echo number_format($subtotal, 0, ',', '.'); ?></th>
                                                            <?php } ?>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <table width="85%" cellspacing="0" cellpadding="6" border="0">
                    <tbody>
                        <tr style="color: #fff;">
                            <td><b></b></td>
                            <td colspan="2"><b></b></td>
                            <td colspan="2"><b></b></td>
                        </tr>
                        <tr bgcolor="#ffffff" class="text2">
                            <td align="left">
                                <font size="3"><b>Ficha de deposito</b></font>
                            </td>
                            <td align="center">
                                <font size="3"><b>Numero de cuenta</b></font>
                            </td>
                            <td align="center">
                                <font size="3"><b>Banco</b></font>
                            </td>
                            <td></td>
                            <td align="center">
                                <font size="3"><b>Beneficiario</b></font>
                            </td>
                        </tr>
                        <tr bgcolor="#ffffff" class="text2">
                            <td align="center" valign="top"><img src="<?php echo $bogota; ?>"></td>
                            <td align="center" valign="top">
                                <font size="3">084 827 851</font>
                            </td>
                            <td align="center" valign="top">
                                <font size="3">
                                Banco AV VILLAS
                                </font>
                            </td>
                            <td></td>
                            <td align="center" valign="top">
                                <font size="3">FUNDRED</font>
                            </td>
                        </tr>
                        <tr bgcolor="#ffffff" class="text2">
                            <td align="left" valign="top" colspan="2">
                                <font size="2">Usted puede pagar en cualquier Banco del grupo AVAL</font>
                            </td>
                            <td align="right" valign="top" colspan="2" class="text2">
                                <font size="3"><b>Valor total:
                                <?php if ($iva != 0) { ?>
                                $<?php echo number_format($subtotal + $iva, 0, ',', '.'); ?>
                                <?php } else { ?>
                                $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                                <?php } ?>
                                </b></font>
                            </td>
                            <td align="right" valign="top" class="text2">
                                <font size="3"><b>Referencia: (<?php echo $facturaNum; ?>)
                                </b></font>
                            </td>
                        </tr>
                        <tr style="color: #fff;">
                            <td>
                            <b>Para confirmar el deposito</b></td>
                            <td colspan="2"><b>Email: info@redsolcolombia.com</b></td>
                            <td colspan="2"><b>Telefono: 656 06 74 </b></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center">
                <form action="index.php?controlador=Index&accion=Logo" target="contenido" method="post">
                    <button class="buscarButton"><?php $doc->texto('FINISH') ?></button>
                </form>
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>