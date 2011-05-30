<?php use_stylesheet("../sfMultipleAjaxUploadGalleryPlugin/slideshow/skitter/css/skitter.styles.css") ?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/skitter/js/jquery-1.5.2.min.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/skitter/js/jquery-ui.min.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/skitter/js/jquery.skitter.min.js");?>

<?php
$correctPath = SfMaugUtils::gallery_path();
?>

<div class="box_skitter box_skitter_large">
    <ul>
        <?php foreach ($gallery->getPhotos() as $photo) { ?>
            <li>
                <a class="block" name="<?php echo $photo->getTitle() ?>" href="<?php echo $correctPath.$gallery->getSlug()."/".$photo->getPicPath() ?>" title="<?php echo $photo->getTitle() ?>">
                    <img src="<?php echo $correctPath.$gallery->getSlug()."/450/".$photo->getPicPath() ?>" alt="<?php echo $photo->getTitle() ?>" />
                </a>
                <div class="label_text">
                    <p>Texte : <?php echo $photo->getTitle() ?></p>
                </div>
            </li>
        <?php } ?>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $(function(){
            $('.box_skitter_large').skitter(
                {
                    velocity: 1,
                    interval: <?php echo $interval ?>,
                    animation: '<?php echo $animation ?>',
                    numbers: <?php echo $hasNumber ?>,
                    navigation: <?php echo $isNavigable ?>,
                    label:  <?php echo $hasLabel ?>,
                    hideTools: <?php echo $hideTools ?>,
                    thumbs: <?php echo $hasThumbs ?>,
                    fullscreen: <?php echo $isFullscreen ?>
                }
            );
        });
    });
</script>