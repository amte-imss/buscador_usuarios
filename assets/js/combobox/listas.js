//Función Unidades relacionadas a la delegacion
function obtener_unidades_cbx(delegacion)
{
    var delegacion = delegacion.value;
    $('#unidad').find('option').remove().end();
    $.ajax({
        method: "GET",
        url: site_url + "/buscador/obtener_unidades/"+delegacion,
    }).done(function( unidad ) {
        //console.log("Respuesta de delegaciones: ", delegacion);
        if(unidad.success)
        {
            $('#unidad').append($('<option>', { value: "", text: "Seleccione..."}));
            if(unidad.datos.length > 0)
            {
                unidad.datos.forEach(function(itemDelegacion) {
                    $('#unidad').append($('<option>', { value: itemDelegacion.clave_unidad, text: itemDelegacion.nombre}));
                });
            }
            else
            {
              //console.log(delegacion)
            }
        }
        else
        {
          //console.log(delegacion)
        }

    });
}