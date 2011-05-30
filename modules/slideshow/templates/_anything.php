<?php use_helper("I18N") ?>
<?php use_stylesheet("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/css/anythingslider.css") ?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/global/js/jquery-1.5.2.min.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/global/js/jquery-ui.min.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.anythingslider.min.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.anythingslider.fx.js");?>
<?php use_javascript("../sfMultipleAjaxUploadGalleryPlugin/slideshow/anything/js/jquery.easing.1.2.js");?>

<?php
    $correctPath = SfMaugUtils::gallery_path();
?>

<ul id="slider1">
        <?php foreach ($gallery->getPhotos() as $photo) { ?>
            <li>
                <a name="<?php echo $photo->getTitle() ?>" href="<?php echo $correctPath.$gallery->getSlug()."/".$photo->getPicPath() ?>" title="<?php echo $photo->getTitle() ?>">
                    <img src="<?php echo $correctPath.$gallery->getSlug()."/450/".$photo->getPicPath() ?>" alt="<?php echo $photo->getTitle() ?>" />
                </a>
                            <?php echo $photo->getTitle() ?>
                </div>
            </li>
        <?php } ?>

</ul>

<script type="text/javascript">
$('#slider1').anythingSlider({
  // Appearance
  width               : null,      // Override the default CSS width
  height              : null,      // Override the default CSS height
  resizeContents      : false,      // If true, solitary images/objects in the panel will expand to fit the viewport

  // Navigation
  startPanel          : 1,         // This sets the initial panel
  hashTags            : true,      // Should links change the hashtag in the URL?
  buildArrows         : true,      // If true, builds the forwards and backwards buttons
  buildNavigation     : false,      // If true, buildsa list of anchor links to link to each panel
  navigationFormatter : null,      // Details at the top of the file on this use (advanced use)
  forwardText         : "&raquo;", // Link text used to move the slider forward (hidden by CSS, replaced with arrow image)
  backText            : "&laquo;", // Link text used to move the slider back (hidden by CSS, replace with arrow image)

  // Slideshow options
  autoPlay            : true,      // This turns off the entire slideshow FUNCTIONALY, not just if it starts running or not
  startStopped        : false,     // If autoPlay is on, this can force it to start stopped
  pauseOnHover        : true,      // If true & the slideshow is active, the slideshow will pause on hover
  resumeOnVideoEnd    : true,      // If true & the slideshow is active & a youtube video is playing, it will pause the autoplay until the video has completed
  stopAtEnd           : false,     // If true & the slideshow is active, the slideshow will stop on the last page
  playRtl             : false,     // If true, the slideshow will move right-to-left
  startText           : "<?php echo __('Start') ?>",   // Start button text
  stopText            : "<?php echo __('Stop') ?>",    // Stop button text
  delay               : 3000,      // How long between slideshow transitions in AutoPlay mode (in milliseconds)
  animationTime       : 600,       // How long the slideshow transition takes (in milliseconds)
  easing              : "swing"    // Anything other than "linear" or "swing" requires the easing plugin
});
</script>