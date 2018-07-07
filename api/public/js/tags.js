var $collectionHolder;

var $addTagButton = $('<button type="button" class="add_tag_link btn btn-xs btn-default" style="margin-top: 10px"><i class="fas fa-plus text-success"></i>&ensp;Add a tag</button>');
var $newLinkLi = $('<li class="control-buttons-tag"></li>').append($addTagButton);

jQuery(document).ready(function() {
    $collectionHolder = $('ul.tags');
    $collectionHolder.append($newLinkLi);

    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function(e) {
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);

    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li class="remove-tags d-flex justify-content-center" title="Delete this tag"></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addTagFormDeleteLink($newFormLi);
}

$('ul.tags li').addClass('remove-tags d-flex justify-content-center');
$('ul.tags li').attr('title', 'Delete this tag');
$('ul.tags li div').removeClass('form-group').addClass("form-inline");
$('ul.tags li div input').css('margin-left', '7px');

jQuery(document).ready(function() {
    $collectionHolder = $('ul.tags');

    $collectionHolder.find('li.remove-tags').each(function() {
        addTagFormDeleteLink($(this));
    });
});

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button type="button" class="btn btn-sm btn-default" style="margin-left: 10px; color: #d93a2b; font-size: 110%">&#10008;</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        $tagFormLi.remove();
    });
}

var tags = document.querySelector('ul.tags');
tags.dataset.prototype = '<div id=\"appbundle_product_tags___name__\" class=\"input-tag\"><div class=\"form-inline\"><label for=\"appbundle_product_tags___name___name\" class=\"form-control-label required\">Name</label><input type=\"text\" id=\"appbundle_product_tags___name___name\" name=\"appbundle_product[tags][__name__][name]\" required=\"required\" maxlength=\"255\" class=\"form-control\" style="margin-left: 7px" /></div></div>';

$('ul.tags li').addClass('text-muted font-weight-bold');
