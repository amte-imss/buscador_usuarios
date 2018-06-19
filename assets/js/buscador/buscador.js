$(function () {
  var down = false;
  $("#btnBuscar").click(function() {
    down = !down;
    if(down){
      $( "#secBusquedaAvanzada" ).show( 1000, function() {});
    }else{
      $( "#secBusquedaAvanzada" ).hide( 1000, function() {});
    }
  });

  $("#form_buscador_general" ).submit(function( event ) {
    var datos = obtener_datos_formulario('form_buscador_general');
    datos.pagina = 0;
    datos.limite = 20;
    busqueda(datos,"#secRespuestaBusqueda",'general');
    event.preventDefault();
  });

  $("#form_buscador_avanzado" ).submit(function( event ) {
    $('#error').hide();
    var datos = obtener_datos_formulario('form_buscador_avanzado');
    var sanitizarDatos = verificarDatosAvanzado(datos);
    if(Object.keys(sanitizarDatos).length > 0){
      busqueda(sanitizarDatos,"#secRespuestaBusqueda",'avanzada');
    }else{
      $('#error').show();
    }
    event.preventDefault();
  });

  $('#secSelectUnidad').hide();
  $('#secSelectDepartamento').hide();
  $('#error').hide();


  $(document).on("click", ".pagination a", function(event){
      event.preventDefault();
      var page = $(this).data("ci-pagination-page");
      var datos = obtener_datos_formulario('form_buscador_general');
      datos.pagina = page;
      datos.limite = 20;
      busqueda(datos,"#secRespuestaBusqueda",'general');
  });
})

function verificarDatosAvanzado(datos){
  var todos = {
    nombre:datos.nombre,
    matricula:datos.matricula,
    apellido_paterno:datos.apellido_paterno,
    apellido_materno:datos.apellido_materno,
    departamento:datos.departamento,
    caregoria:datos.categoria,
    delegacion:datos.delegacion,
    unidad:datos.unidad
  }
  if(todos.nombre == "Escribe nombre ..." || todos.nombre == undefined || todos.nombre == '' || todos.nombre == null){
      delete todos.nombre;
  }
  if(todos.matricula == "Escribe matrícula ..." || todos.matricula == undefined || todos.matricula == '' || todos.matricula == null){
      console.log("DELETE MATRICULA");
     delete todos.matricula;
  }
  if(todos.apellido_paterno == "Escribe apellido paterno ..." || todos.apellido_paterno == undefined || todos.apellido_paterno == '' || todos.apellido_paterno == null){
     delete todos.apellido_paterno;
  }
  if(todos.apellido_materno == "Escribe apellido materno ..." || todos.apellido_materno == undefined || todos.apellido_materno == '' || todos.apellido_materno == null){
     delete todos.apellido_materno;
  }
  if(todos.departamento == "Seleccione..." || todos.departamento == undefined || todos.departamento == '' || todos.departamento == null){
     delete todos.departamento;
  }
  if(todos.caregoria == "Seleccione..." || todos.caregoria == undefined || todos.caregoria == '' || todos.caregoria == null){
     delete todos.caregoria;
  }
  if(todos.delegacion == "Seleccione..." || todos.delegacion == undefined || todos.delegacion == '' || todos.delegacion == null){
     delete todos.delegacion;
  }
  if(todos.unidad == "Seleccione..." || todos.unidad == undefined || todos.unidad == '' || todos.unidad == null){
     delete todos.unidad;
  }
  return todos;
}

function obtener_datos_formulario(id_formulario){
  var inputs = $('#'+id_formulario+' :input');
  var values = {};
  inputs.each(function() {
    if(this.name != '' && this.name != undefined)
      values[this.name] = $(this).val();
  });
  return values;
}

function convertirMayusculas(e) {
    e.value = e.value.toUpperCase();
}

function cambiarPlaceholder(obj){
  $("#buscadorGeneral")[0].value = "";
  if(obj.value == 'matricula'){
    $("#buscadorGeneral").attr("placeholder", "Escribe la búsqueda por matrícula");
  }else{
    $("#buscadorGeneral").attr("placeholder", "Escribe la búsqueda por "+obj.value);
  }
}

function busqueda(datos,elemento_resultado,tipo_busqueda){
  $(elemento_resultado).empty();
  if(tipo_busqueda == "general"){
    $.ajax({
  		url: site_url+"/buscador/obtener_busqueda_general",
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
  			$(elemento_resultado).html(response.data);
  		} else {
  			$(elemento_resultado).html(html_message(response.error, 'danger'));
  		}
  	})
  	.fail(function( jqXHR, textStatus ) {
  		$(elemento_resultado).html("Ocurrió un error durante la búsqueda, inténtelo más tarde.");
  	})
  }
  if(tipo_busqueda == 'avanzada'){
    $.ajax({
  		url: site_url+"/buscador/obtener_busqueda_avanzada",
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
  			$(elemento_resultado).html(response.data);
  		} else {
  			$(elemento_resultado).html(html_message(response.error, 'danger'));
  		}
  	})
  	.fail(function( jqXHR, textStatus ) {
  		$(elemento_resultado).html("Ocurrió un error durante la búsqueda, inténtelo más tarde.");
  	})
  }
}

function mostrarUnidades(obj){
  $('#secSelectDepartamento').hide();

  if(obj.value != 'Seleccione...'){
      $('#secSelectUnidad').show();
      obtenerOpcionesUnidad(obj.value);
  }else{
      $('#secSelectUnidad').hide();
      $('#secSelectDepartamento').hide();
  }
}

function mostrarDepartamentos(obj){
  //console.log("Unidad: ", obj.value);
  if(obj.value != 'Seleccione...' && obj.value != ''){
      $('#secSelectDepartamento').show();
      obtenerOpcionesDepartamento(obj.value);
  }else{
      $('#secSelectDepartamento').hide();
  }
}

function obtenerOpcionesUnidad(id_delegacion){
  $('#selectUnidad').find('option').remove().end();
  datos = {
    id_delegacion: id_delegacion
  }
  $.ajax({
    url: site_url+"/buscador/obtenerUnidades",
    data: datos,
    method: 'POST',
    dataType: 'JSON',
    beforeSend: function( xhr ) {
      console.log("cargando ...");
    }
  })
  .done(function(response) {
    if(response.success){
      var unidades = response.datos;
      $('#selectUnidad').append($('<option>', { value: "", text: "Seleccione..."}));
      console.log(unidades);
      Array.prototype.forEach.call(unidades , function(unidad) {
        $('#selectUnidad').append($('<option>', { value: unidad.clave_unidad, text: unidad.nombre}));
      })
    } else {
      $('#selectUnidad').find('option').remove().end();
    }
  })
  .fail(function( jqXHR, textStatus ) {
    $('#selectUnidad').find('option').remove().end();
    console.log("Ocurrio un error");
  })
}

function obtenerOpcionesDepartamento(clave_unidad){
  $('#selectDepartamento').find('option').remove().end();
  datos = {
    clave_unidad: clave_unidad
  }
  $.ajax({
    url: site_url+"/buscador/obtenerDepartamentos",
    data: datos,
    method: 'POST',
    dataType: 'JSON',
    beforeSend: function( xhr ) {
      console.log("cargando ...");
    }
  })
  .done(function(response) {
    if(response.success){
      var departamentos = response.datos;
      $('#selectDepartamento').append($('<option>', { value: "", text: "Seleccione..."}));
      Array.prototype.forEach.call(departamentos , function(departamento) {
        $('#selectDepartamento').append($('<option>', { value: departamento.clave_departamental, text: departamento.nombre}));
      })
    } else {
      $('#selectDepartamento').find('option').remove().end();
    }
  })
  .fail(function( jqXHR, textStatus ) {
    $('#selectDepartamento').find('option').remove().end();
    console.log("Ocurrio un error");
  })
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
