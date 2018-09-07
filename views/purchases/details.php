<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div class="container">

    <table class="table" border="0" cellspacing="0" cellpadding="3" style="width: 100%;">        
        <tr class="headall">                
            <th class="headinit"><?php $doc->texto('QUANTITY') ?></th>
            <th class="head"><?php $doc->texto('PRODUCT_NAME') ?></th>                
            <th class="head"><?php $doc->texto('POINTS') ?></th>
            <th class="head"><?php $doc->texto('PRICE') ?></th>
            <th class="head"><?php $doc->texto('TOTAL') ?></th> 
            <th class="head"><?php $doc->texto('TOTAL_POINTS') ?></th> 
        </tr>      
        <?php foreach ($detalles as $detalle) { ?>
            <tr class="class<?php echo $estilo; ?>"> 
                <th class="init"><?php echo $detalle->getCantidad(); ?></th>
                <th class="item"><?php echo $detalle->getProducto()->getNombre(); ?></th>
                <th class="item"><?php echo number_format($detalle->getProducto()->getPuntos(), 2, ',', '') ?></th>
                <th class="item">
                    <?php if ($detalle->getProducto()->getIva() == 0) {
                        echo '&#36;' . $detalle->getProducto()->getPrecio();
                    } else {
                        echo '&#36;' . number_format((($detalle->getProducto()->getPrecio() * $detalle->getProducto()->getIva()) / 100) + $detalle->getProducto()->getPrecio(), 0, ',', '.');
                    }?>
                </th>
                <th class="item"> <?php if ($detalle->getProducto()->getIva() == 0) {
                        echo '&#36;' . number_format($detalle->getCantidad() * 
                                $detalle->getProducto()->getPrecio(), 0, ',', '.');
                    } else {
                        echo '&#36;' . number_format($detalle->getCantidad() * 
                                ((($detalle->getProducto()->getPrecio() * $detalle->getProducto()->getIva()) 
                                / 100) + $detalle->getProducto()->getPrecio()), 0, ',', '.');
                    }?>
                </th>  
                <th class="item"><?php echo number_format($detalle->getProducto()->getPuntos()*$detalle->getCantidad(), 
                        2, ',', '') ?></th>
            </tr>
            <?php
            if ($estilo == 1) {
                $estilo = 2;
            } else {
                $estilo = 1;
            }
        }
        ?>   
    </table>    
</div> 
