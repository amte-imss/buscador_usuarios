$(function(){
       $("ul.dropdown-menu li a.option-input-tablero").click(function(event){
        event.preventDefault();
        $('#btn-filtro-tablero').html($(this).text()+'<span class="caret"></span>');
        $('#filtro_texto').val($(this).attr('data-id'));
        
        var mostrar = $(this).attr('data-id');
        
        console.log(mostrar);
       
        if (mostrar=='nombre') {

            $('#apellido_paterno').show();
        } else {

        	$('#apellido_paterno').hidden();
        }
        

    }); 
});