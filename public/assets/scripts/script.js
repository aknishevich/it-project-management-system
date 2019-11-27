var responseHtml = '';
var removeMember =  function (button) {
    var params = button.getAttribute('data-ajax-params'),
        url = button.getAttribute('data-ajax-url'),
        replaceBlockId = button.getAttribute('data-ajax-replace-id');

    if (confirm('Are you sure you want to delete this member?')) {

        $.ajax({
            type: 'DELETE',
            url: url,
            data: JSON.parse(params)
        }).done(function(response) {
            $('#' + replaceBlockId).replaceWith(response);
        });
    }
}