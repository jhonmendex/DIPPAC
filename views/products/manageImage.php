<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<div id="dropbox">
    <form action="index.php?controlador=Products&accion=subirimagen" method="post" id="miform" enctype="multipart/form-data">
        <span class="message">
            <img src="images/leyenda.png"></br>
            <input type="file" class="file" name="pic" style="cursor:pointer;" onpropertychange="enviarIE();"/>
            <input type="hidden" name="versioning" value="nohtml5"/>
        </span>
    </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input.file").si();
        $(".file").change(function(){            
            var file = this.files[0];
            if(!file.type.match(/^image\//)){
                parent.parent.message('Solo se permiten imagenes');
            }else{
                max_file_size = 1048576 * 2;
                if(file.size>max_file_size){
                    parent.parent.message('Archivo muy grande');
                }else{
                    $('#miform').submit();
                }
            }
        });
    });
    
    
    function enviarIE(){            
        $('#miform').submit();                    
    }
</script>