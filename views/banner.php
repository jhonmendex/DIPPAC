<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<style>
    body{
     background: #fff; 
    }
    #dropdowna{
     font-family: 'Arial';
     color: #000;
     text-decoration: none;
    }
    button{
color: rgb(102, 102, 102);
border-radius: 5px;
box-shadow: none;
background-color: orange;
cursor: pointer;
padding: 1px 40px;
cursor:pointer;
border: none;
    }
    #sesion{
     color: #423F54;
    float: right;
    font-family: Arial;
    font-size: 11px;
    margin-right: 20px;
    margin-top: 20px;
    }
</style>
<script>
    function ir(idmenu, urlprincipal){
        if(idmenu==7){
            var frameset = parent.document.getElementById("nopos");
            origCols = frameset.cols;
            frameset.cols = "0, *";
            var frameset2 = parent.document.getElementById("sipos");
            origCols = frameset2.cols;
            frameset2.cols = "132, *";
        }else{
            var frameset = parent.document.getElementById("nopos");
            origCols = frameset.cols;
            frameset.cols = "230, *";
            var frameset2 = parent.document.getElementById("sipos");
            origCols = frameset2.cols;
            frameset2.cols = "0, *";
        }
        
        top.contenido.location=urlprincipal;
        top.menu.location="index.php?controlador=Index&accion=Menu&idmenu="+idmenu;
    }  
</script>  
<div style="float: left;">
    <img style="width: 145px" src="images/nuevologol.png" alt="logo" />    
</div>
<div id="sesion">
    <strong> <a id="dropdowna" href="#" data-dropdown="#dropdown-1"><b> <i class="icon-sesion"></i> </b><?php $doc->texto('WELCOME', $nombre) ?></a></strong>   
       
</div>
<div style="float: right; margin-right: 20px; clear: right; margin-top: 0px;">
    <form action="index.php" method="get" target="_parent">
        <input type="hidden" name="controlador" value="User"/>
        <input type="hidden" name="accion" value="salir"/> 
        <div id="dropdown-1" class="dropdown dropdown-tip">
            <div class="dropdown-menu">
                <div style="color: rgb(0, 0, 0);font-family: 'FUTURABOOK';font-size: 10px; height: 33px;  margin-top: 2px;  padding: 8px;
    text-align: right;  width: 100px;">
                    <strong><?php echo $perfil ?></strong>
                    <hr>
                    <button><?php $doc->texto('EXIT', $nombre) ?></button>
                </div>
            </div>
        </div>
    </form>   
</div>


<?php if($menus!=null){?>
<ul id="navigation"> 
    <?php foreach ($menus as $value) { ?>
        <li class="home">
            <a onclick="ir('<?php echo $value['idmen'] ?>','<?php echo $value['urlprin'] ?>')" style="cursor: pointer;">
                <span><?php echo $value['namemen'] ?></span>
            </a>
        </li> 
    <?php } ?>
</ul>
<?php }?>
<script type="text/javascript">
    $(function() {
        var d=300;
        $('#navigation a').each(function(){
            $(this).stop().animate({
                'marginTop':'-80px'
            },d+=150);
        });

        $('#navigation > li').hover(
        function () {
            $('a',$(this)).stop().animate({
                'marginTop':'-60px'
            },200);
        },
        function () {
            $('a',$(this)).stop().animate({
                'marginTop':'-80px'
            },200);
        }
    );
    });
</script>