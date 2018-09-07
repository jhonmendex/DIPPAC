<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>

 <?php if(sizeof($productos)!=0){
    foreach ($productos as $value) {?>
<div class="product">	
    <div id="caja"><?php echo $value["nombre"]?></div>																										
    <a title="<?php echo $value["nombre"]?>" style="cursor: default"><img src="<?php echo $value["imagen"]?>"/></a>
        <div class="desc">
                <p>Codigo: <span><?php echo $value["referencia"]?></span></p>
                <p>Puntos: <span><strong><?php echo number_format($value["puntos"],2,",",".")?></strong></span></p>
        </div>	
        <div class="price-box">
                <p>$<span class="price"> <?php echo number_format($value["precioiva"],0,",",".")?></span></p>
                <p class="per-peace">x <?php echo  ucfirst($value["unidad"])?></p>
        </div>
        <div class="cl"></div>	
    <p style="font-size: 20px; margin-top: 12px;">Cantidad: 
        <span>
            <input name="cantidad" 
                   value="<?php echo isset($_SESSION["canasta"][$value["id"]])?$_SESSION["canasta"][$value["id"]]:""?>" 
                   size="8" 
                   style="width: 45px; height: 38px; font-size:16px" 
                   maxlength="6" 
                   id="<?php echo $value["id"]?>pro"
                   onkeydown="return validar(event, '<?php echo $value["unidad"]?>')" 
                   onkeyup="actualizar('<?php echo $value["id"]?>',$(this).attr('id'), '<?php echo $value["unidad"]?>')"/>
        </span>
        <?php if(!isset($_SESSION["canasta"][$value["id"]])){?>
            <span id="<?php echo $value["id"]?>proimg" style="display: none">
                <img src="images/icart.png" width="24" height="24"/>
            </span>
            <?php }else{?>
            <span id="<?php echo $value["id"]?>proimg">
                <img src="images/icart.png" width="24" height="24"/>
            </span>
       <?php }?>
    </p>																													
</div>
<?php }?>
<?php }?>	
<div class="cl"></div>    
<?php if(sizeof($productos)!=0){
 if($pagina){?>
<a style="font-size: 14px; font-family: sans-serif; margin: 20px 0px 0px 7px; padding-bottom: 0px;" href="index.php?controlador=Shopping&accion=catalogoajax&pag=<?php echo $pagina;?>&cat=<?php echo $categoria;?>&order=<?php echo $orden;?>">Cargar mas productos</a>
<?php }
}?>
<script type="text/javascript">  
    function actualizar(idproducto, id,unidad){
        //alert("nimierda "+idproducto);
        $.ajax({
           type: "POST",
           url: "index.php?controlador=Shopping&accion=updateitemtoShop",
           dataType: "json",
           data: {cantidad: $('#' + id).val(),idpro: idproducto, unid:unidad},
           success: function(data) {
               if(data.respuesta=="si")
               $('#' + id + "img").show();
               else
               $('#' + id + "img").hide();
           }
       });
    }
    
    function validar(e,unidad) {
    if (e.keyCode == 86 && e.ctrlKey)
        return true;
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    if (tecla == 48)
        return true;
    if (tecla == 49)
        return true;
    if (tecla == 50)
        return true;
    if (tecla == 51)
        return true;
    if (tecla == 52)
        return true;
    if (tecla == 53)
        return true;
    if (tecla == 54)
        return true;
    if (tecla == 55)
        return true;
    if (tecla == 56)
        return true;
    if (tecla == 57)
        return true;
    if (tecla == 188 && unidad!='und')
        return true;   
    if (tecla == 190 && unidad!='und')
        return true; 
    patron = /1/; //ver nota
    te = String.fromCharCode(tecla);
    return patron.test(te);
    }
</script>