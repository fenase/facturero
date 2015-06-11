function guardarLista(){
    var data = $("#lista .elemento").map(function() { return $(this).children(".id").html(); }).get();
    $("input[name=listSortOrder]").val(data.join("|"));
    $("input[name=accion]").val("guardar");
    form.submit();
}

function proyectoEliminarParticipante(id){
    window.location.href = window.location.href + '&sacarParticipante=' + id;
}
