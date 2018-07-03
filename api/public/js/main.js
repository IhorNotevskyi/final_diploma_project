(function () {
    $('table thead tr th').css('verticalAlign', 'middle');
    $('table tbody tr td').css('verticalAlign', 'middle');
})();

function confirmDelete() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    } else {
        return false;
    }
}