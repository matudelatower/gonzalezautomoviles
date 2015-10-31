function bootstrapCollectionBorrarItem(item) {
    $(item).parent().parent().remove();
}

$(document).ready(function () {
    $(".select2").select2();

    //Date range picker
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        language: "es",
        autoclose: true
    });
});