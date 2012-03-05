$(function() {
    setTimeout(function() {
        $('#messenger-window').show('slide', {direction: 'right'}, 500);
        setTimeout(function() {
            $('#messenger-window').hide('slide', {direction: 'right'}, 500);
        }, 4000 );
    }, 500);
});


