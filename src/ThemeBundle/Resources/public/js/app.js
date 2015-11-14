function bootstrapCollectionBorrarItem(item) {
    $(item).parent().parent().remove();
}

function inicializarFecha() {
//Date picker
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true
    });
}


$(document).ready(function () {
    $(".select2").select2();
    inicializarFecha();

});