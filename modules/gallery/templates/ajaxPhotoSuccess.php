json;;<?php if (isset($form)) : ?>
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
        <input type="hidden" name="id" value="<?php echo $id ?>"/>
    </form>
<script type="text/javascript">
$('.blockTitle').html('<?php echo $title ?>');
if (document.getElementById('colorize_color') != null) {
    var picker = new jscolor.color(document.getElementById('colorize_color'), {});
}
$('form[id*="ajax"]').submit(function (event) {
    event.preventDefault();
    $('input[type="submit"]').attr('disabled', 'disabled');
    $.post($(this).attr('action'), $(this).serialize(),
            function(data) {
                $.unblockUI();
                $('#pictures_list').html(data);

             });
});
</script>
<?php endif; ?>