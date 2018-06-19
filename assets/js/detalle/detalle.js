function cambiarHistorial(evt){
  var mes = $("#selectMes option:selected").val();
  var anio =  $("#selectAnio option:selected").val();
  if(mes != 0 || anio != 0){
    $("#secHistorico").html("");
    var datos = {
      'mes':mes,
      'anio':anio,
      'matricula': document.location.href.split('/')[7]
    }
    $.ajax({
  		url: site_url+"/buscador/historico",
  		data: datos,
  		method: 'POST',
  		dataType: 'JSON',
  		beforeSend: function( xhr ) {
        $("#cargador").html(create_loader());
  		}
  	})
  	.done(function(response) {
      remove_loader();
  		if(response.resultado==true){
  			$("#secHistorico").html(response.data);
  		} else {
  			$("#secHistorico").html(html_message(response.error, 'danger'));
  		}
  	})
  	.fail(function( jqXHR, textStatus ) {
  		$("#secHistorico").html("Ocurrió un error durante la búsqueda, inténtelo más tarde.");
  	})
  }
}

/**
 *	Método que muestra una imagen (gif animado) que indica que algo esta cargando
 *	@return	string	Contenedor e imagen del cargador.
*/
function create_loader(){
	$("#cargador").show();
}

/**
 *	Método que remueve el contenedor e imagen de cargando
*/
function remove_loader(){
	$("#cargador").hide();
}
