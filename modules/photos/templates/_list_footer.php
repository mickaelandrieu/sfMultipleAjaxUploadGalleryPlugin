<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/js/jquery/jquery-ui-1.8.10.custom.min.js") ?>
<?php use_javascript("http://github.com/malsup/blockui/raw/master/jquery.blockUI.js?v2.31") ?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/js/jscolor.js") ?>
<?php use_stylesheet("../sfMultipleAjaxUploadGalleryPlugin/css/growl.css") ?>

<script type="text/javascript">
$(document).ready(function() {
    $('.notice').delay(2000).fadeOut('slow');
    $('.error').delay(2000).fadeOut('slow');
});

$('form[action*="batch"]').submit(function (event) {
    if ($(this).find('select').val() != 'batchDelete') {
        event.preventDefault();

        $.post($(this).attr('action'), $(this).serialize(),
                function(data) {
                    var elem = data.split(';;');
                    //error
                    if (elem.length > 1&& elem[0] == 'error') {
                        $.growlUI('Error Notification', elem[1]);
                        $('div.growlUI').addClass('growlUIError');
                    //renderTextJSON
                    } else if (elem.length > 1 && elem[0] == 'json') {
                        $.growlUI('Success Notification', elem[1]);
                        var obj = eval('(' + elem[2] + ')');
                        for(x in obj) {
                            $('img[x-image-id*="'+x+'"]').attr('src', obj[x]);
                        }
                    //success
                    } else {
                        $.blockUI({
                                message: data,
                                theme:     true,
                                title:    'This is your title'
                             });
                        $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
                    }
            });
    }
});
</script>