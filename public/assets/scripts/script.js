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
};
var showEditTaskModal = function (button) {
    var params = button.getAttribute('data-ajax-params'),
        url = button.getAttribute('data-ajax-url'),
        replaceBlockId = button.getAttribute('data-ajax-replace-id'),
        modalTitle = button.getAttribute('data-modal-title');

    $.ajax({
        type: 'GET',
        url: url
    }).done(function(response) {
        $('.modal-title').html(modalTitle);
        $('#' + replaceBlockId).html(response);
        $('#exampleModal').modal('show');
    });
};
var createEditTaskModal = function (button) {
    var params = button.getAttribute('data-ajax-params'),
        url = button.getAttribute('data-ajax-url'),
        replaceBlockId = button.getAttribute('data-ajax-replace-id'),
        modalTitle = button.getAttribute('data-modal-title'),
        modalButtonText = button.getAttribute('data-modal-button');

    $.ajax({
        type: 'GET',
        url: url
    }).done(function(response) {
        $('.modal-title').html(modalTitle);
        $('#' + replaceBlockId).html(response);
        $('#exampleModal').modal('show');
        if(modalButtonText) {
            $('#modal-button').text(modalButtonText);
        }
    });
};