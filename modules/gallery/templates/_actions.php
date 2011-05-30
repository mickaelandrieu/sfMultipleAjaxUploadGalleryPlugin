<div id="<?php echo $contextual? "contextual_":"" ?>actions_<?php echo $photo->getId() ?>" class="contextual" <?php echo !$contextual?'class="photo_action_full"':"";?> style="display: none;border: 1px solid #cecece;-webkit-border-radius:5px;-moz-border-radius:5px;border-radius:5px;text-align: center">
<?php if(!$contextual){ ?>
    <a href="#" onclick="$('#actions_<?php echo $photo->getId() ?>').hide('slow');return false;" style="float: left;"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/back.png"/>
    </a>
<?php } ?>
<?php
$sizes = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_thumbnails_sizes");
foreach ($sizes as $i=>$size) {
    if($size>150){
        $size = $sizes[$i-1];
        break;
    }
}
?>

<div class="clear"></div>
<?php if(!$photo->getIsDefault()){ ?>
    <a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_default', $photo) ?>')" class="default"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/setdefault.png" title="<?php echo __("backend.action.edit.setdefault",array(),"sfmaug");?>"/></a>
<?php } ?>
<?php if($contextual){ ?><a href="javascript:void(0)" onclick="$('.photo_action_full').hide();$('#actions_<?php echo $photo->getId() ?>').show();" class="edit"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/edit.png" title="<?php echo __("backend.action.edit", array(), 'sfmaug');?>"/></a><?php } ?>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_delete', $photo) ?>')" class="delete"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/trash.png" title="<?php echo __("backend.action.remove", array(), 'sfmaug');?>"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_crop', $photo) ?>')" id="rehook" title="<?php echo __("backend.action.crop", array(), 'sfmaug') ?>"><img rel="overlay" style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/crop.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_rotate_left', $photo) ?>')" title="<?php echo __("backend.action.rotate.left", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/rotateL.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_rotate_right', $photo) ?>')" title="<?php echo __("backend.action.rotate.right", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/rotateR.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_flip_v', $photo) ?>')" title="<?php echo __("backend.action.flip.horizontal", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/flipH.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_flip_h', $photo) ?>')" title="<?php echo __("backend.action.flip.vertical", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/flipV.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_choose_colorize', $photo) ?>')" title="<?php echo __("backend.action.colorize", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/colorize.png"/></a>
<?php /*<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_choose_filigrane', $photo) ?>')" title="<?php echo __("overlay filigrane this picture", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/sepia.png"/></a>*/?>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_black_and_white', $photo) ?>')" title="<?php echo __("backend.action.greyscale", array(), 'sfmaug') ?>"><img rel="overlay" style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/greyscale.png"/></a>

<?php if(!$contextual){ ?>
<div style="margin-right: 5px">
    <img src="<?php echo $photo->getFullPicpath($size); ?>"/>
</div>
<div class="clear"></div>
<p><?php echo __("backend.gallery.photo.description.invite",array(),"sfmaug") ?></p>
<textarea id="<?php echo $photo->getId()."_value" ?>" ><?php echo $photo->getTitle() ?></textarea>
<input onclick="saveTitle(<?php echo $photo->getId();?>)" type="button" value="OK"/>
<?php } ?>
</div>
