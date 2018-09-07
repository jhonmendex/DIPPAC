<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<script>
    function actualizaritems(idform){
        if($('#cantidad'+idform).val()!=''){
           
            if($('#cantidad'+idform).val()==0){  
                message('Debe ingresar una cantidad mayor a 0','images/iconos_alerta/error.png');
            }else{
                var productoedit={};                   
                productoedit['cantidad']=$('#cantidad'+idform).val();
                productoedit['id']=idform; 
                $.ajax({                
                    type: "POST",
                    dataType: "json",
                    url: "index.php?controlador=Shopping&accion=edit_item",
                    data: productoedit,
                    async:false,
                    success: function( response ) 
                    {                            
                        respuesta=response.result;  
                        puntos=response.points;
                        total=response.totalitem;
                        totalpuntos=response.totalpoints;
                        totaltotal=response.totalShop;
                        if(respuesta=='true'){  
                            message('Se ha actualizado el item','images/iconos_alerta/ok.png');  
                            $("#puntos"+idform).html(puntos);
                            $("#total"+idform).html(total);
                            $("#totalpuntos").html(totalpuntos);
                            $("#totalventa").html(totaltotal);
                        }
                    },
                    error: function( error ){
                        alert( error );
                    }
                });
            }
        }else{
            message('Debe ingresar una cantidad','images/iconos_alerta/error.png'); 
        }      
    }
    
    $(document).ready(function() {        
        $('img').css("border","0");
<?php if ($eliminado == 'ok') { ?>
            message('Se ha eliminado correctamente el item','images/iconos_alerta/ok.png');        
<?php } ?>
    });
</script>
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
                Precio del articulo (IVA)
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
            <th class="head">

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
            <div style="float: left;margin-left: 10px;"">
                 <input maxlength="3" style="text-align: center;" type="text" size="4" value="<?php echo $detalle->getCantidad(); ?>" id="cantidad<?php echo $detalle->getProducto()->getId(); ?>"/>
            </div>
            <div style="float: left; margin-left: 5px;">
                <a onclick="actualizaritems($(this).attr('id'))" id="<?php echo $detalle->getProducto()->getId(); ?>" style="cursor: pointer;">
                    <img class="delete" src="images/refresh.png" title="Actualizar cantidad"/>                       
                </a>
            </div>
            <div style="clear: left;"></div>
            </th>
            <th class="item">
                <?php
                if ($detalle->getProducto()->getIva() == 0) {
                    echo '&#36;' . number_format($detalle->getProducto()->getPrecio(), 0, ',', '.');
                } else {
                    echo '&#36;' . number_format((($detalle->getProducto()->getPrecio()
                            * $detalle->getProducto()->getIva()) / 100) +
                            $detalle->getProducto()->getPrecio(), 0, ',', '.');
                }
                ?>
            </th>
            <th class="item">

                <?php echo number_format($detalle->getProducto()->getPuntos(), 2, ',', '.'); ?>

            </th>
            <th class="item">
            <div id="total<?php echo $detalle->getProducto()->getId(); ?>">
                <?php
                if ($detalle->getProducto()->getIva() == 0) {
                    echo '&#36;' . number_format($detalle->getCantidad() *
                            $detalle->getProducto()->getPrecio(), 0, ',', '.');
                } else {
                    echo '&#36;' . number_format($detalle->getCantidad() *
                            ((($detalle->getProducto()->getPrecio() * $detalle->getProducto()->getIva())
                            / 100) + $detalle->getProducto()->getPrecio()), 0, ',', '.');
                }
                ?>
            </div>
            </th>
            <th class="item">
            <div id="puntos<?php echo $detalle->getProducto()->getId(); ?>">
                <?php echo number_format($detalle->getCantidad() * $detalle->getProducto()->getPuntos(), 2, ',', '.'); ?>
            </div>
            </th>
            <th class="item">
                <a href="index.php?controlador=Shopping&accion=delItem&idproducto=<?php echo $detalle->getProducto()->getId(); ?>&idcategoria=<?php echo $categoriaA; ?>&paginaact=<?php echo $page; ?>">
                    <img class="delete" src="images/delete.gif" title="Eliminar item"/>                       
                </a>
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
                <strong>SUBTOTAL</strong> 
            </th>
            <th colspan="1" class="init">
        <div id="totalventa">
            <?php echo '&#36;' . number_format($subtotal + $iva, 0, ',', '.') ?>
        </div>
        </th>
        <th colspan="1" class="item">
        <div id="totalpuntos">
            <?php echo number_format($puntos, 2, ',', '.') ?>
        </div>
        </th>
        </tr>
    </table> 
    <div style="margin-top: 20px; ">
        <div style="float: left;">
            <form action="index.php" method="get">              
                <input type="hidden" name="idcategoria" value="<?php echo $categoriaA; ?>"/>
                <input type="hidden" name="controlador" value="Shopping"/>
                <input type="hidden" name="accion" value="factura"/>
                <button class="buscarButton">finalizar compra</button>

            </form>
        </div>  
        <div style="float: left;">
            <form action="index.php" method="get">                
                <input type="hidden" name="controlador" value="Shopping"/>
                <input type="hidden" name="pag" value="<?php echo $page; ?>"/>
                <input type="hidden" name="cat" value="<?php echo $categoriaA; ?>"/>                
                <button class="buscarButton">continuar comprando</button>
            </form>
        </div>
        <div style="float: left;">
            <form action="index.php" method="get">                
                <input type="hidden" name="pag" value="1"/>
                <input type="hidden" name="cat" value="<?php echo $categoriaA; ?>"/> 
                <input type="hidden" name="controlador" value="Shopping"/>
                <input type="hidden" name="accion" value="cancelar"/>
                <button class="buscarButton">Cancelar Orden</button>
            </form>
        </div>
    </div>           
</div>