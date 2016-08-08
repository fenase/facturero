function agregarProyecto(){
    $("input[name=accion]").val("guardar");
    fNuevoProyecto.submit();
}

function guardarLista(){
    var data = $("#lista .elemento").map(function(){
        return $(this).children(".id").html();
    }).get();
    $("input[name=listSortOrder]").val(data.join("|"));
    $("input[name=accion]").val("guardar");
    form.submit();
}

function proyectoAgregarParticipante(){
    window.location.href = window.location.href + '&agregarParticipante=' + $("#participantesDisponibles").find('option:selected').attr('id');
}

function proyectoEliminarParticipante(id){
    window.location.href = window.location.href + '&sacarParticipante=' + id;
}



//Script para mostrar ventanas modal
var modal, btn, span;
$(document).ready(function(){

// Get the modal
    modal = document.getElementById('myModal');

// Get the <span> element that closes the modal
    span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
    document.getElementById('openModal').onclick = function(){
        modal.style.display = "block";
    };

// When the user clicks on <span> (x), close the modal
    span.onclick = function(){
        modal.style.display = "none";
    };

// When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event){
        if(event.target == modal){
            modal.style.display = "none";
        }
    };

});
