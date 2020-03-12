<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
    "http://www.w3.org/TR/html4/frameset.dtd">
<HTML>
    <HEAD>
        <TITLE>DPAAC</TITLE> 
    </HEAD> 
    
    <frameset border="0px" rows="50,*" cols="*" bordercolor="#FFFFFF">
        <frame name="banner" scrolling="no" noresize src="<?php echo $arreglo[0] ?>">
        <?php if ($idmenu != 7) { ?>
            <frameset id="nopos" border="0px" rows="*" cols="230,*" >     
                    <frame name="menu" scrolling="auto" noresize src="<?php echo $arreglo[1] ?>">  
                <frame name="contenido" scrolling="auto" noresize src="<?php echo $arreglo[2] ?>"> 
            </frameset>
            <frameset id="sipos" border="0px" rows="*" cols="0,*" >                     
                <frame name="contenido" scrolling="auto" noresize src="<?php echo $arreglo[2] ?>"> 
            </frameset>
        <?php } else { ?>                
        <frameset id="nopos" border="0px" rows="*" cols="0,*" >     
                <frame name="menu" scrolling="auto" noresize src="<?php echo $arreglo[1] ?>">
                <frame name="contenido" scrolling="auto" noresize src="<?php echo $arreglo[2] ?>"> 
            </frameset>
        <frameset id="sipos" border="0px" rows="*" cols="132,*" >                     
                <frame name="contenido" scrolling="auto" noresize src="<?php echo $arreglo[2] ?>"> 
            </frameset>       
        <?php } ?> 
    </frameset><noframes></noframes>
    	
</HTML> 