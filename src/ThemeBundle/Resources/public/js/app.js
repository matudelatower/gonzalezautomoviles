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
    //Date range picker
    $('.daterange').daterangepicker({
        format: 'DD/MM/YYYY',
        "locale": {
            "separator": " - ",
            "applyLabel": "Aplicar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa",
                "Do"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Deciembre"
            ],
            "firstDay": 1
        },
    });
    //Timepicker
    $(".timepicker").timepicker({
        showInputs: false,
        showMeridian: false,
    });
}

function modalAlert(msg) {
    $('#modal-alert .modal-body').html(msg);
    $('#modal-alert').modal('toggle');
}


$(document).ready(function () {

    $(document).ajaxStart(function () {
        $.blockUI(
            {
                message: '<div class="progress progress-striped active"><div class="progress-bar" style="width: 100%"></div></div>',
                css: {backgroundColor: 'none', border: 'none'},
                baseZ: 1050,
            }
        )
    });
    $(document).ajaxStop($.unblockUI);

    $(".select2").select2({
        language: "es",
        "language": {
            "noResults": function () {
                return "No se encontraron resultados";
            }
        },
    });
    inicializarFecha();

    $(".data-table").DataTable({
        "paging": false,
        "autoWidth": true,
        "info": false,
        "scrollX": true,
        "language": {
            "search": "Buscar:",
            "zeroRecords": "Sin resultados"
        }
    });

});