<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
<script>
    $(document).ready(function(){
        $(".various3").fancybox({
            'width'                : 800,
            'height'               : 350,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false                           
        });
            
        $(".various4").fancybox({
            'width'                : 650,
            'height'               : 220,
            'autoScale'            : false,
            'transitionIn'         : 'elastic',
            'transitionOut'        : 'elastic',
            'speedIn'              :  500,
            'type'                 : 'iframe',
            'hideOnOverlayClick'   : false                           
        });                      
<?php if ($message != null) { ?>
            message('<?php echo $message ?>','<?php echo $icon_message ?>');
<?php } ?>
    
    });
</script>
<style>
.input-icon.left input {
    padding-left: 33px !important;
}
</style>
<body class="login">
    <div class="logo"> 
        <img src="images/logo.png"/>
    </div>
    <div class="content">
        <form id="formlogin" method="post" action="index.php" class="form-vertical login-form" novalidate="novalidate">
            <h3 class="form-title" style="text-align: center">Bienvenido a ACPAC</h3>
			<div class="control-group">
				<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
				<label class="control-label visible-ie8 visible-ie9">Username</label>
				<div class="controls">
					<div class="input-icon left"> 
						<i class="icon-user"></i>
                                                <?php $view->input("user", "text", "Alias o codigo", array('required' => true), array('placeholder' => 'nombre' ,'class' => 'm-wrap placeholder-no-fix')); ?>
					
                                        </div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label visible-ie8 visible-ie9">Password</label>
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
                                                <?php $view->input("pwd", "password", $doc->t('PASSWORD'), array('required' => true), array('placeholder' => 'Contrasena','class' => 'm-wrap placeholder-no-fix')); ?>
					        <?php $view->input("cont", "hidden",'',array(), array('value' =>'User')); ?>  
                                                <?php $view->input("act", "hidden", '',array(), array('value' => 'validacion')); ?> 
                                        </div>
				</div>
			</div>
			<div class="form-actions">
				<button class="btn blue pull-right logininputb" type="submit">
				ENTRAR <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<div class="forget-password">
				<h4>Olvidaste tu contraseña ?</h4>
				<p>
					No te preocupes, haz click <a id="forget-password" class="various4" href="index.php?controlador=Novinculado&accion=frmrecordarpass"> aquí</a>
					para recuperar tu contraseña.
				</p>
			</div>
			<div class="create-account">
				<p>
					Aún no estas en ACPAC ?&nbsp; 
					<a id="register-btn" class="various3" href="index.php?controlador=Novinculado">Registrate</a>
				</p>
			</div> 
		</form>
        </div>
    <script> 
    $.backstretch([
        "images/bglogin/bg2.jpg",
          "images/bglogin/bg1.jpg",
          "images/bglogin/bg3.jpg"
        ], {
            fade: 750,
            duration: 4000
        });
    </script>
</body>