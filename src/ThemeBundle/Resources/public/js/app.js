function bootstrapCollectionBorrarItem(item) {
    $(item).parent().parent().remove();
}

$(document).ready(function () {
    $(".select2").select2();
});