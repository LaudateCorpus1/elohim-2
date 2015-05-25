$(document).ready(function() {
    initLightboxes();
});


function initLightboxes() {
    var $lightboxes = $('div.lightbox.lightbox-container'),
        $lightboxTriggers = $('a.lightbox, span.lightbox, input.lightbox, button.lightbox');

    $lightboxes.hide();

    $lightboxTriggers.bind('click', function(e) {
        e.preventDefault();
        openLightbox($($(this).data('target')));
    });
}

function openLightbox(target) {
    var targetwidth = target.css('width').substr(0,target.css('width').length - 2);

    target.dialog({
        "title": (typeof target.data('title') === undefined)?"":target.data('title'),
        "width": targetwidth,
        "modal": false,
        "height": "auto",
        "position": { my: 'center', at: 'top' },
        "closeText": "X",
        open: function() {
        },
        close: function() {
            target.css('width', targetwidth);
        }
    });

    if (typeof target.data('class') !== undefined)
        target.dialog("option", "dialogClass", target.data('class'));
}

function popupMessage(title, message) {
    var lightbox = $('#lightbox-popupMessage');
    lightbox.html('<div class="popupMessage-content">' + message + '</div>');
    lightbox.data('title', title);

    openLightbox($('#lightbox-popupMessage'));
}

function nullOrFalse($val) {
    return ($val == false || typeof $val === "undefined");
}



function convertToDate(time) {
    var d = new Date(time*1000);
    return (d.getUTCFullYear()+"-"+(d.getUTCMonth() + 1)+"-"+d.getUTCDate() + "&nbsp;&nbsp;&nbsp;" + d.getUTCHours()+":"+d.getUTCMinutes()+":"+d.getUTCSeconds() + "UTC/GMT");
}