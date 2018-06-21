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
    datos.limite = 1500;
    if(datos.tipo == 'delegacion'){
        datos.busqueda = remove_acentos(datos.busqueda);
    }
    if(datos.tipo == 'nombre'){
        datos.busqueda = remove_acentos(datos.busqueda);
    }
    busqueda(datos,"#secTabla",'general',true);
    event.preventDefault();
  });

  $("#form_buscador_avanzado" ).submit(function( event ) {
    $('#error').hide();
    var datos = obtener_datos_formulario('form_buscador_avanzado');
    var sanitizarDatos = verificarDatosAvanzado(datos);
    if(Object.keys(sanitizarDatos).length > 0){
      sanitizarDatos.offset = 0;
      sanitizarDatos.limit = 1500;
      busqueda(sanitizarDatos,"#secTabla",'avanzada',true);
    }else{
      $('#error').show();
    }
    event.preventDefault();
  });

  $('#secSelectUnidad').hide();
  $('#secSelectDepartamento').hide();
  $('#error').hide();

  $(document).on("click", "#paginacionGeneral a", function(event){
      event.preventDefault();
      $("#paginacionGeneral").children().each(function() {
        if(this.className != ""){
            this.className = "";
        }
      });
      $(this)[0].parentElement.className = "active";
      var page = $(this).attr('href').split('/')[7];
      var datos = obtener_datos_formulario('form_buscador_general',false);
      datos.pagina = page;
      datos.limite = $("#selectTotalRows")[0].value;
      busqueda(datos,"#secTabla",'general');
      //return showPage(+$(this).text());
  });

  $(document).on("click", "#paginacionAvanzada a", function(event){
        event.preventDefault();
        $("#paginacionAvanzada").children().each(function() {
          if(this.className != ""){
              this.className = "";
          }
        });
        $(this)[0].parentElement.className = "active";
        var page = $(this).attr('href').split('/')[7];
        var datos = obtener_datos_formulario('form_buscador_avanzado');
        var sanitizarDatos = verificarDatosAvanzado(datos);
        sanitizarDatos.offset = page;
        sanitizarDatos.limit = $("#selectTotalRows")[0].value;
        busqueda(sanitizarDatos,"#secTabla",'avanzada',false);
        //return showPage(+$(this).text());
  });

    // // Number of items and limits the number of items per page
    // var numberOfItems = $(".pagination li").length;
    // var limitPerPage = 2;
    // // Total pages rounded upwards
    // var totalPages = Math.ceil(numberOfItems / limitPerPage);
    // // Number of buttons at the top, not counting prev/next,
    // // but including the dotted buttons.
    // // Must be at least 5:
    // var paginationSize = 7;
    // var currentPage;
    //
    // function showPage(whichPage) {
    //     if (whichPage < 1 || whichPage > totalPages) return false;
    //     currentPage = whichPage;
    //     $(".pagination li").hide()
    //         .slice((currentPage-1) * limitPerPage,
    //                 currentPage * limitPerPage).show();
    //     // Replace the navigation items (not prev/next):
    //     $(".pagination li").slice(1, -1).remove();
    //     getPageList(totalPages, currentPage, paginationSize).forEach( item => {
    //         $("<li>").addClass("page-item")
    //                  .addClass(item ? "current-page" : "disabled")
    //                  .toggleClass("active", item === currentPage).append(
    //             $("<a>").addClass("page-link").attr({
    //                 href: "javascript:void(0)"}).text(item || "...")
    //         ).insertBefore("#next-page");
    //     });
    //     // Disable prev/next when at first/last page:
    //     $("#previous-page").toggleClass("disabled", currentPage === 1);
    //     $("#next-page").toggleClass("disabled", currentPage === totalPages);
    //     return true;
    // }
    //
    // // Show the page links
    // $(".pagination").show();
    // showPage(1);
    //
    // //Use event delegation, as these items are recreated later
    // $(document).on("click", ".pagination li", function () {
    //   return showPage(+$(this).text());
    // });
    // $("#next-page").on("click", function () {
    //     console.log(currentPage);
    //     return showPage(currentPage+1);
    // });
    //
    // $("#previous-page").on("click", function () {
    //     return showPage(currentPage-1);
    // });
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
      //console.log("DELETE MATRICULA");
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
  if($("#selectBusqueda")[0].value != 'correo'){
      e.value = e.value.toUpperCase();
  }
}

function cambiarPlaceholder(obj){
  $("#buscadorGeneral")[0].value = "";
  if(obj.value == 'matricula'){
    $("#buscadorGeneral").attr("placeholder", "Escribe la búsqueda por matrícula");
  }else{
    $("#buscadorGeneral").attr("placeholder", "Escribe la búsqueda por "+obj.value);
  }
}

function busqueda(datos,elemento_resultado,tipo_busqueda,paginacion){
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
        if(paginacion){
            $('#paginador').html(response.paginacion);
            // Include the prev/next buttons:
            $(".pagination").append(
                $("<li>").addClass("page-item").attr({ id: "previous-page" }).append(
                    $("<a>").addClass("page-link").attr({
                        href: "javascript:void(0)"}).text("Anterior")
                ),
                $("<li>").addClass("page-item").attr({ id: "next-page" }).append(
                    $("<a>").addClass("page-link").attr({
                        href: "javascript:void(0)"}).text("Siguiente")
                )
            );
        }
        if(response.total > response.limite){
            $('#numRows').html(response.opcionesRenglones);
        }else{
            $('#numRows').html("");
        }


  		} else {
        remove_loader();
  			$(elemento_resultado).html(html_message(response.error, 'danger'));
  		}
  	})
  	.fail(function( jqXHR, textStatus ) {
      remove_loader();
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
        if(paginacion){
            $('#paginador').html(response.paginacion);
        }
        if(response.total > response.limite){
            $('#numRows').html(response.opcionesRenglones);
        }else{
            $('#numRows').html("");
        }
  		} else {
        //console.log(response);
        remove_loader();
  			$(elemento_resultado).html(html_message(response.error, 'danger'));
  		}
  	})
  	.fail(function( jqXHR, textStatus ) {
      remove_loader();
  		$(elemento_resultado).html("Ocurrió un error durante la búsqueda, inténtelo más tarde.");
  	})
  }
}

function cambiarRenglones(obj, buscador){
  var num_renglones = obj.value;
  if(buscador == 'general'){
    if(num_renglones != "" && num_renglones != undefined){
      var datos = obtener_datos_formulario('form_buscador_general');
      datos.pagina = 0;
      datos.limite = num_renglones;
      if(datos.tipo == 'delegacion'){
          datos.busqueda = remove_acentos(datos.busqueda);
      }
      if(datos.tipo == 'nombre'){
          datos.busqueda = remove_acentos(datos.busqueda);
      }
      //console.log(datos);
      busqueda(datos,"#secTabla",'general');
    }else{
      var datos = obtener_datos_formulario('form_buscador_avanzado');
      var sanitizarDatos = verificarDatosAvanzado(datos);
      sanitizarDatos.offset = 0;
      sanitizarDatos.limit = num_renglones;
      busqueda(sanitizarDatos,"#secTabla",'avanzada');
    }
  }
  if(buscador == 'avanzado'){
    if(num_renglones != "" && num_renglones != undefined){
      var datos = obtener_datos_formulario('form_buscador_avanzado');
      var sanitizarDatos = verificarDatosAvanzado(datos);
      if(Object.keys(sanitizarDatos).length > 0){
        sanitizarDatos.offset = 0;
        sanitizarDatos.limit = num_renglones;
        //console.log(sanitizarDatos);
        busqueda(sanitizarDatos,"#secTabla",'avanzada',undefined);
      }
    }
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
      //console.log("cargando ...");
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
      //console.log("cargando ...");
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
    //console.log("Ocurrio un error");
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

/**
 * fUNCIÓN QUE ELIMINA ACENTOS
 *
 */
function remove_acentos(cadena){
  cadena=cadena.replace('Á','A');
  cadena=cadena.replace('É','E');
  cadena=cadena.replace('Í','I');
  cadena=cadena.replace('Ó','O');
  cadena=cadena.replace('Ú','U');
  cadena=cadena.replace('Ñ','N');
  cadena=cadena.replace('Ä','A');
  cadena=cadena.replace('Ë','E');
  cadena=cadena.replace('Ï','I');
  cadena=cadena.replace('Ö','O');
  cadena=cadena.replace('Ü','U');
  return cadena;
}

// Returns an array of maxLength (or less) page numbers
// where a 0 in the returned array denotes a gap in the series.
// Parameters:
//   totalPages:     total number of pages
//   page:           current page
//   maxLength:      maximum size of returned array
function getPageList(totalPages, page, maxLength) {
    if (maxLength < 5) throw "maxLength must be at least 5";

    function range(start, end) {
        return Array.from(Array(end - start + 1), (_, i) => i + start);
    }

    var sideWidth = maxLength < 9 ? 1 : 2;
    var leftWidth = (maxLength - sideWidth*2 - 3) >> 1;
    var rightWidth = (maxLength - sideWidth*2 - 2) >> 1;
    if (totalPages <= maxLength) {
        // no breaks in list
        return range(1, totalPages);
    }
    if (page <= maxLength - sideWidth - 1 - rightWidth) {
        // no break on left of page
        return range(1, maxLength-sideWidth-1)
            .concat([0])
            .concat(range(totalPages-sideWidth+1, totalPages));
    }
    if (page >= totalPages - sideWidth - 1 - rightWidth) {
        // no break on right of page
        return range(1, sideWidth)
            .concat([0])
            .concat(range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
    }
    // Breaks on both sides
    return range(1, sideWidth)
        .concat([0])
        .concat(range(page - leftWidth, page + rightWidth))
        .concat([0])
        .concat(range(totalPages-sideWidth+1, totalPages));
}
