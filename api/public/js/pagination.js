$(document).ready(function(){
    $('.delete').click(function(){
        var el = this;
        var id = this.id;
        var splitid = id.split("_");
        var deleteid = splitid[1];

        $.ajax({
            url: '/admin/tags?page=' + number,
            type: 'GET',
            data: {rowcount: $('#rowcount').val()},
        }).done(function(data) {
            $( '#pagination' ).html( data );
        });
    });
});