var resultados_por_pagina = 5;
var pagina_actual = 1;
var pagina_ultima = 0;

$(window).ready(function(){
	var total_registros = $("#mytable>tbody>tr").length;
	pagina_ultima = Math.round(total_registros / resultados_por_pagina);
});

var cargarPagina = function(intPaginaP){
	if(intPaginaP < 1){intPaginaP = 1;}
	if(intPaginaP > pagina_ultima){intPaginaP = pagina_ultima;}
  	$("#mytable>tbody>tr").addClass("linea-oculta");
 	var primer_registro = (intPaginaP - 1) * resultados_por_pagina;
	for (var i = primer_registro; i < (primer_registro + resultados_por_pagina); i++){
		$("#mytable>tbody>tr").eq(i).removeClass("linea-oculta");
	}
  	pagina_actual = intPaginaP;
	$("#indicador_paginas").html("Página: " + pagina_actual + " / " + pagina_ultima);
}