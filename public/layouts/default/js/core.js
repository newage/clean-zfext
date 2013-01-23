/*
 * All function for work core
 *
 */
var requireSymbol = ' *';

$(function() {

    $('form[required=true] .control-group').each(function() {
        if ($(this).find(':input :last').prop('required')) {
            $(this).find('label').append(requireSymbol);
        }
    });
});
