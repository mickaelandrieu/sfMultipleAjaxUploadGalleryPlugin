<?php use_helper("I18N") ?>
<?php use_stylesheet("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/css/anythingslider.css") ?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.anythingslider.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.anythingslider.fx.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.easing.1.2.js");?>

<?php
    $correctPath = SfMaugUtils::gallery_path();
?>

        <ul id="slider_anything_<?php echo $gallery->getSlug()?>">
                <?php foreach ($gallery->getPhotos() as $photo) { ?>
                <li>
                    <div>
                            <?php $imageInfos = getimagesize($photo->getPath()."/".$photo->getPicpath()); ?>
                        <a name="<?php echo $photo->getTitle() ?>" rel="gallery" class="fancybox-gallery" href="<?php echo $correctPath.$gallery->getSlug()."/".$photo->getPicPath() ?>" title="<?php echo $photo->getTitle() ?>">
                            <img src="<?php echo $photo->getFullPicPath() ?>" alt="<?php echo $photo->getTitle() ?>" <?php echo $imageInfos[3] ?> style="max-height: <?php echo sfConfig::get('app_sfMultipleAjaxUploadGalleryPlugin_anything_max_height') ?>px"/>
                        </a>
                        <?php echo $photo->getTitle() ?>
                    </div>
                </li>
                <?php } ?>

        </ul>
<style type="text/css">
    .anythingSlider span.arrow{
        margin: 50px -80px 0 0;
    }
    .anythingSlider span.arrow.forward{
        margin: 50px 0 0 -80px;
    }
</style>
<script type="text/javascript">
$('#slider_anything_<?php echo $gallery->getSlug()?>').anythingSlider({
    theme           : 'metallic',
    easing          : 'easeInOutBack',
    resizeContents      : false // If true, solitary images/objects in the panel will expand to fit the viewport
				
//				autoPlayLocked  : true,  // If true, user changing slides will not stop the slideshow
//				resumeDelay     : 10000, // Resume slideshow after user interaction, only if autoplayLocked is true (in milliseconds).
});
//$('#slider_anything_<?php echo $gallery->getSlug()?> a.fancybox-gallery').attr('rel', 'gallery').fancybox();

</script>