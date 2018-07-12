(function () {
    $('table thead tr th').css('verticalAlign', 'middle');
    $('table tbody tr td').css('verticalAlign', 'middle');
})();

$(document).ready(function() {
    $('.delete-items').click(function() {
        var el = this;
        var id = this.id;
        var splitId = id.split("_");
        var deleteId = splitId[1];

        swal({
            position: 'top',
            title: 'Are you sure you want to delete this item?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#19aa4e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: '/admin/' + deleteItem + '/delete/' + deleteId,
                        type: 'POST',
                        data: {id: deleteId}
                    })
                    .done(function(response){
                        swal({
                            position: 'top',
                            title: 'Deleted!',
                            text: 'Your item has been deleted.',
                            type: 'success'
                        });
                        $(el).closest('tr').css('background', 'tomato');
                        $(el).closest('tr').fadeOut(800, function () {
                            $(this).remove();
                        });
                    })
                    .fail(function(){
                        swal({
                            position: 'top',
                            title: 'Oops...',
                            text: 'Something went wrong with ajax!',
                            type: 'error'
                        });
                    });
                });
            },
            allowOutsideClick: false
        });
        $(this).preventDefault();
    });
});