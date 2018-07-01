(function() {
    var th = document.querySelectorAll('table thead tr th');
    var td = document.querySelectorAll('table tbody tr td');

    for (var i = 0; i < td.length; i++) {
        td[i].style.verticalAlign = 'middle';
    }

    for (var j = 0; j < th.length; j++) {
        td[j].style.verticalAlign = 'middle';
    }
})();

function confirmDelete() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    } else {
        return false;
    }
}