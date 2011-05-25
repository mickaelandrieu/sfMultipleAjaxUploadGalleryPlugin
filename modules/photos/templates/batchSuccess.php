<?php if (isset($form)) : ?>
    <form id="ajax" action="<?php echo $url ?>" method="POST">
    <?php if (isset($add_field)): ?>
        <?php foreach ($add_field as $lbl_type => $type) : ?>
            <?php foreach ($type as $component) : ?>
                <label for="<?php echo $component['id'] ?>"><?php echo $component['label'] ?></label>
                <input type="<?php echo $lbl_type ?>" id="<?php echo $component['id'] ?>"
                    name="<?php echo $component['name'] ?>" value="<?php echo $component['value'] ?>"
                     onClick="<?php echo $component['onclick'] ?>"/>
                <br/>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo $form ?>
    <input type="submit" value="Valider"/>
    <?php foreach ($ids as $value) : ?>
        <input type="hidden" name="ids[]" value="<?php echo $value ?>"/>
    <?php endforeach; ?>
    </form>

<script type="text/javascript">
if (document.getElementById('colorize_color') != null) {
    var picker = new jscolor.color(document.getElementById('colorize_color'), {});
}
$('.blockTitle').html('<?php echo $title ?>');
$('form[id*="ajax"]').submit(function (event) {
    event.preventDefault();
    $('input[type="submit"]').attr('disabled', 'disabled');
    $.post($(this).attr('action'), $(this).serialize(),
            function(data) {
                $.unblockUI();
                var elem = data.split(';;');
                $.growlUI('Success Notification', elem[1]);
                if (elem.length > 1 && elem[0] == 'json') {
                    data = elem[2];
                }
                var obj = eval('(' + data + ')');
                for(x in obj) {
                    $('img[x-image-id*="'+x+'"]').attr('src', obj[x]);
                }
                //window.location = data
                $('input[type="submit"]').attr('disabled', '');

             }).error(function() {
                 $.unblockUI();
                 $.growlUI('Error Notification', 'Error Ajax Execution');
                 $('div.growlUI').addClass('growlUIError');
             });
});
</script>
<?php endif; ?>

