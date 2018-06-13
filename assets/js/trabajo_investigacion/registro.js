$(document).ready(function() {
    // Add button Delete in row
    $('tbody tr')
        .find('td')
        //.append('<input type="button" value="Delete" class="del"/>')
        .parent() //traversing to 'tr' Element
        .append('<td><a href="#" class="delrow"><i class="fa fa-times" aria-hidden="true"></i></a></td>');


    // Add row the table
    $('#btnAddRow').on('click', function() {
        var lastRow = $('#tabla_autores tbody tr:last').html();
        //alert(lastRow);
        $('#tabla_autores tbody').append('<tr>' + lastRow + '</tr>');
        $('#tabla_autores tbody tr:last input').val('');
    });


    // Delete row on click in the table
    $('#tabla_autores').on('click', 'tr a', function(e) {
        var lenRow = $('#tabla_autores tbody tr').length;
        e.preventDefault();
        if (lenRow <= 1) {
            alert("No se pueden eliminar todas las columnas de la tabla");
        } else {
            $(this).parents('tr').remove();
        }
    });

    $('input:radio[name=publicado]').on('click', function() {
       publicado();
    });
    
});


function publicado() {
    var publicado = $('input[name=publicado]:checked', '#form_registro_investigacion').val();
    if(publicado == 'true'){
        $('#referencia').removeAttr('disabled');
    }else{
        $('#referencia').attr('disabled','disabled');
    }
    
}