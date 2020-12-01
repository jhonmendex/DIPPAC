<?php
defined('EXECG__') or die('<h1>404 - <strong>Not Found</strong></h1>');
?>
    <script>
        getParticipantsByGuardian('<?php echo $nameSpon; ?>')
    </script>
    <div>
		<h1 class="code">CREAR GRUPO MUESTRAL</h1> 
	    <div class="form-group">
			<label for="codigo">nombre de la muestra</label>
			<input type="text" class="form-control" id="codigo" placeholder="usuario mas nombre muestra">
		</div>
		<button onclick="creategroupMuestral('<?php echo $nameSpon; ?>')" class="btn btn-primary mb-2">Crear Codigo</button>
	</div>
    <div id="list">
    </div>
