<?php defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');?>
    <ul class="sidebar-menu">
        <li class="header"><?php echo $tituloMenu; ?></li>
        <?php foreach ($submenus as $value) { ?>
            <li class="treeview">
                <a href="<?php echo $value['urlmenu']?>" target="contenido">
                    <i class="<?php echo $value['icono']?>"></i>
                    <span class="mls"><?php echo $value['nombresubmenu']?></span>
                </a>
            </li>
        <?php } ?>        
    </ul> 
<script>
    $(document).ready(function() {
        $('img').css("border","0");                
    });
</script>