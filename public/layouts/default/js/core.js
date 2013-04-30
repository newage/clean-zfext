/*
 * All function for work core
 *
 */
var requireSymbol = ' *';

/**
 * Show confirm modal
 * @param {object} option
 *  heading:'Confirm your action',
 *  body:'This is a confirm modal, click confirm button to perform your action',
 *  callback: function() {
 * @returns {mixed}
 */
function confirmModal(options) {
    var context = $('#confirmModal');

    var defaults = {
        heading: null,
        body: null,
        callback : null
    };

    var options = $.extend(defaults, options);
    if (options.heading != null) {
        $(context).find('.modal-header h3').text(options.heading);
    }
    if (options.body != null) {
        $(context).find('.modal-body p').text(options.body);
    }

    $(context).modal('show');
    $('#confirmYesBtn', context).click(function(){
        if(options.callback != null) {
            options.callback();
        }
        $(context).modal('hide');
    });
}

$(function() {

    $('form[required=true] .control-group').each(function() {
        if ($(this).find(':input :last').prop('required')) {
            $(this).find('label').append(requireSymbol);
        }
    });

    $(document).ajaxError(function() {
        $('#errorModal').find('.modal-body p').text('Server is busy. Please try later.');
        $('#errorModal').modal('show');
    });

    $(document).ajaxComplete(function(event, request, settings) {
        var requestJson = JSON.parse(request.responseText);
        if (requestJson.error !== undefined) {
            $('#errorModal').find('.modal-header h3').text('Error response');
            $('#errorModal').find('.modal-body p').text(requestJson.error);
            $('#errorModal').modal('show');
        }
    });
});
