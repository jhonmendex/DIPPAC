<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">

    <table class="table" cellspacing="0">
        <tr class="headall">
            <th class="headinit">
                Articulo
            </th>
            <th class="head">
                Codigo
            </th>
            <th class="head" style="width: 80px;">
                Cantidad
            </th>
            <th class="head" style="width: 90px;">
                Precio del articulo
            </th>
            <th class="head" style="width: 70px;">
                Puntos
            </th>
            <th class="head" style="width: 90px;">
                Total
            </th>
            <th class="head" style="width: 70px;">
                Total puntos
            </th>

        </tr>
        <?php foreach ($detail as $detalle) { ?>
            <tr class="class<?php echo $estilo; ?>">
                <th class="init">
                    <?php echo $detalle->getProducto()->getNombre(); ?>
                </th>
                <th class="item">
                    <?php echo $detalle->getProducto()->getReferencia(); ?>
                </th>
                <th class="item">
                    <?php echo $detalle->getCantidad(); ?>
                </th>
                <th class="item">
                    <?php
                    if ($detalle->getProducto()->getIva() == 0) {
                        echo '&#36;' . number_format($detalle->getProducto()->getPrecio(),
                                0, ',', '.');
                    } else {
                        echo '&#36;' . number_format((($detalle->getProducto()->getPrecio() 
                                * $detalle->getProducto()->getIva()) / 100) + $detalle->getProducto()->getPrecio(),
                                0, ',', '.');
                    }
                    ?>
                </th>
                <th class="item">
                    <?php echo number_format($detalle->getProducto()->getPuntos(),
                                2, ',', '.'); ?>
                </th>
                <th class="item">
                    <?php
                    if ($detalle->getProducto()->getIva() == 0) {
                        echo '&#36;' . number_format($detalle->getCantidad() * $detalle->getProducto()->getPrecio(), 0, ',', '.');
                    } else {
                        echo '&#36;' . number_format($detalle->getCantidad() * ((($detalle->getProducto()->getPrecio() 
                                * $detalle->getProducto()->getIva()) / 100) + $detalle->getProducto()->getPrecio()), 0, ',', '.');
                    }
                    ?>
                </th>
                <th class="item">
                    <?php echo number_format($detalle->getCantidad() * $detalle->getProducto()->getPuntos(),
                                2, ',', '.'); ?>

                </th>

            </tr>
            <?php
            if ($estilo == 1) {
                $estilo = 2;
            } else {
                $estilo = 1;
            }
        }
        ?>
        <tr>
            <th colspan="5" style="text-align: right; padding: 10px; font-size: 14px;" >
                <strong>VALOR ANTES DE IVA</strong> 
            </th>
            <th colspan="1" class="init">
                <?php echo number_format($subtotal, 0, ',', '.') ?>
            </th>
            <th colspan="1" class="item">
                <?php echo number_format($puntos,2, ',', '.') ?>
            </th>

        </tr>
        <tr>
            <th colspan="5" style="text-align: right; padding: 10px; font-size: 14px;" >
                <strong>VALOR IVA</strong> 
            </th>
            <th colspan="1" class="init">
                <?php echo number_format($totaliva, 0, ',', '.') ?>
            </th>


        </tr>
        <tr>
            <th colspan="5" style="text-align: right; padding: 10px; font-size: 14px;" >
                <strong>TOTAL</strong> 
            </th>
            <th colspan="1" class="init">
                <?php
                if ($totaliva == 0) {

                    echo number_format($subtotal, 0, ',', '.');
                } else {
                    echo number_format($subtotal + $totaliva, 0, ',', '.');
                }
                ?>
            </th>


        </tr>
    </table> 
    <div style="margin-top: 20px; ">
        <div style="float: left;">            
            <form action="index.php" method="get">          
                <div style="clear: left;margin-bottom: 50px">
                    Tipo de envio: <select name="envio">       
                        <option value="<?php echo $envios[0]; ?>"><?php echo $envios[0]; ?></option>
                        <option value="<?php echo $envios[1]; ?>"><?php echo $envios[1]; ?></option>         
                    </select>
                </div>
                <input type="hidden" name="controlador" value="Shopping"/>
                <input type="hidden" name="accion" value="genFactura"/>               
                <button class="buscarButton">Terminar y generar factura</button>
            </form>
        </div>
        <div style="float: left;margin-top: 70px">

            <form action="index.php" method="get">                
                <input type="hidden" name="controlador" value="Shopping"/>
                <input type="hidden" name="accion" value="orden"/>
                <input type="hidden" name="idcategoria" value="<?php echo $categoriaA; ?>"/>                
                <button class="buscarButton">volver</button>
            </form>
        </div>                
    </div>

</div> 