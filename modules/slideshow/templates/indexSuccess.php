<?php use_helper('I18N') ?>
<?php include_component("slideshow","widget", array(
    "gallery"=> $galleries->getFirst(),
    "template" => "anything"
)) ?>


<?php echo !count($galleries) ? __("slideshow.index.empty") : __("slideshow.index.title");?>
<div>
    <?php foreach ($galleries as $i=>$gallery): ?>
    <div class="cont">
        <div>
		<a class="title" href="<?php echo url_for(@showGallery, $gallery) ?>">
                	<h3><?php echo $gallery->getTitle() ?></h3>
		</a>
	</div>
        <div>
		<a href="<?php echo url_for(@showGallery, $gallery) ?>">
                    <?php 
                    $uploadDir = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery");
                    $webDir = sfConfig::get("sf_web_dir");
                    $correctPath = substr($uploadDir, strlen($webDir), strlen($uploadDir)-strlen($webDir));
                    $default = $gallery->getPhotoDefault()->getPicpath() == "" ? sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_defaultPicture") :
                            $correctPath.$gallery->getSlug()."/".
				sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_portfolio_thumbnails_size")."/".$gallery->getPhotoDefault()->getPicpath();
                    ?>
                	<img src="<?php echo $default ?>"/>
            	</a>
	</div>
    </div>
    <?php echo count($galleries) >= 4 ? '<div class="clear"></div>' : ""; ?>
    <?php endforeach; ?>
</div>



