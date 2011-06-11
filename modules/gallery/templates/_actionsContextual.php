<div id="contextual_actions_<?php echo $photo->getId() ?>" class="contextual sfmaug-actions">

<div class="clear"></div>
<?php if(!$photo->getIsDefault()){ ?>
    <a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_default', $photo) ?>')" class="default"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/setdefault.png" title="<?php echo __("backend.action.edit.setdefault",array(),"sfmaug");?>"/></a>
<?php } ?>
<a href="javascript:void(0)" onclick="$('.photo_action_full').hide();$('#actions_<?php echo $photo->getId() ?>').show();" class="edit"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/edit.png" title="<?php echo __("backend.action.edit", array(), 'sfmaug');?>"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_delete', $photo) ?>')" class="delete"><img src="/sfMultipleAjaxUploadGalleryPlugin/images/trash.png" title="<?php echo __("backend.action.remove", array(), 'sfmaug');?>"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_crop', $photo) ?>')" id="rehook" title="<?php echo __("backend.action.crop", array(), 'sfmaug') ?>"><img rel="overlay" style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/crop.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_rotate_left', $photo) ?>')" title="<?php echo __("backend.action.rotate.left", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/rotateL.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_rotate_right', $photo) ?>')" title="<?php echo __("backend.action.rotate.right", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/rotateR.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_flip_v', $photo) ?>')" title="<?php echo __("backend.action.flip.horizontal", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/flipH.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_flip_h', $photo) ?>')" title="<?php echo __("backend.action.flip.vertical", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/flipV.png"/></a>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_choose_colorize', $photo) ?>')" title="<?php echo __("backend.action.colorize", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/colorize.png"/></a>
<?php /*<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_choose_filigrane', $photo) ?>')" title="<?php echo __("overlay filigrane this picture", array(), 'sfmaug') ?>"><img rel="overlay"  style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/sepia.png"/></a>*/?>
<a href="javascript:void(0)" onclick="ajaxPhotoEdition('<?php echo url_for('photo_ajax_black_and_white', $photo) ?>')" title="<?php echo __("backend.action.greyscale", array(), 'sfmaug') ?>"><img rel="overlay" style="width:16px" src="/sfMultipleAjaxUploadGalleryPlugin/images/greyscale.png"/></a>

</div>
