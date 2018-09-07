<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>   
<style>
    #r1:hover{ 
       background: #EAEBFF
    }   
    #r2:hover{   
       background: #EAEBFF 
    }   
    #r1:active{  
       background: #D3D6FF
    }   
    #r2:active{      
       background: #D3D6FF 
    }        
</style> 
<div id="main"> 
    <div class="maxcontent" id="content"> 
        <div id="fancybox-title" class="fancybox-title-float" style="display: block; z-index: 50"><table cellspacing="0" cellpadding="0" id="fancybox-title-float-wrap"><tbody><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">Reorganizar productos</td><td id="fancybox-title-float-right"></td></tr></tbody></table></div>
        <div class="container" style="margin-bottom: 20px; margin-top: 10px">              
            <div style="width: 100%;">     
                <fieldset class="colorleyend" style="width: 100%; padding: 10px; ">
                    <legend class="colorleyendinto">Reorganización de productos</legend> 
                    <div id="cajaselect3" style="margin-bottom: 15px; margin-top: 15px">
                        Bodega: <strong><?php echo $nombrebodega?></strong>                        
                    </div>
                    <p>Seleccione el tipo de reorganización de desea realizar.</p>
                    <table border="0" width="100%" style="padding: 20px; text-align: center">  
                        <tr style="font-size: 20px; color: #fff">   
                            <td style="background-color: #369808; padding: 5px; border-radius: 5px">
                             Reorganizar un producto     
                            </td> 
                            <td style="background-color: #369808; padding: 5px; border-radius: 5px">
                             Reorganizar varios productos  
                            </td>   
                        </tr>    
                        <tr>          
                         <td style="padding: 10px">                            
                             <a class="various4" title="Reorganizar un producto" href="index.php?controlador=Reorganization&accion=reorganizarProducto"> 
                                 <div id="r1" width="100%">            
                                     <img src="images/imagenes-menu/reorganizar1.png">
                                 </div>  
                             </a>
                         </td>       
                         <td style="padding: 10px">                 
                             <a class="various4" title="Reorganizar varios productos" href="index.php?controlador=Reorganization&accion=reorganizarProductos">
                                 <div width="100%" id="r2"> 
                                     <img src="images/imagenes-menu/reorganizar2.png">
                                 </div>
                             </a>   
                         </td>  
                        </tr> 
                    </table> 
                </fieldset>     
            </div> 
        </div>
    </div> 
</div>      
<script>   
        $(".various4").fancybox({
            'width'                : 1000,
            'height'               : 490,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500, 
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false,
            'showCloseButton'      : true 
        }); 
</script>