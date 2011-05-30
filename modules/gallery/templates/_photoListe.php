<?php use_helper('I18N') ?>
<?php use_javascript("http://github.com/malsup/blockui/raw/master/jquery.blockUI.js?v2.31") ?>

<style type="text/css">
        fieldset.optdual { width: 500px; }
        .optdual { position: relative; }
        .optdual .offset { position: absolute; left: 18em; }
        .optlist label { width: 16em; display: block; }
        #dl_links { margin-top: .5em; }
        #photos-list { list-style-type: none; margin: 0; padding: 0; }
	#photos-list li { margin: 3px 3px 3px 0; padding: 1px; float: left; font-size: 4em; text-align: center; }
	</style>

<script>
function showActionFull() {;
    var hasEditing = false;
    $('.contextual').each(function(index) {
        if ($(this).css('display') == 'block') {
            hasEditing = true;
        }
    });
    if (!hasEditing) {
        $('.photo_action_full').slideDown('fast');
    }
};
    function saveTitle(id){
        var title = $('#' + id + '_value').val();
        $.blockUI({ message: '<br/><h1><?php echo __('Please wait...') ?></h1><br/><img src="/sfMultipleAjaxUploadGalleryPlugin/images/loadingAnimation.gif" alt=""/><br/>' });
        $.post('<?php echo url_for(@photoUpdateTitle) ?>',
            {id: id, title : title},
            function(data){
                $('#sf_admin_container').prepend("<div class='notice'>"+data+"</div>");
                $('.notice').delay(2000).slideUp('slow');
                $('#actions_' + id).slideUp('slow', function () {
                        showActionFull();
                        $.unblockUI();
                });
            });
    }

    function ajaxPhotoEdition(url){
        $.blockUI({ message: '<br/><h1><?php echo __('Please wait...') ?></h1><br/><img src="/sfMultipleAjaxUploadGalleryPlugin/images/loadingAnimation.gif" alt=""/><br/>' });
        $.post(url,
            {},
            function(data){
                var elem = data.split(';;');
                if (elem.length > 1 && elem[0] == 'json') {
                    $.blockUI({
                            message: elem[1],
                            theme:     true
                         });
                    $('.blockOverlay').attr('title','Click to unblock').click($.unblockUI);
                } else {
                    $("#pictures_list").html(data);
                    $.growlUI('Success Notification', 'Success Operation');
                    
                }
       });
        /*
        .error(function() {
            $.unblockUI();
            $.growlUI('Error Notification', 'Error Ajax Execution');
            $('div.growlUI').addClass('growlUIError');
        })*/
    }

    <?php if($photos->count()>0){?>
    $(function() {
            $( "#photos-list" ).sortable({
                            handle: '.basic',
                            update: function(){
                                    $('#working').show();
                                    var order = $('#photos-list').sortable('serialize');
                                    $.post('<?php echo url_for(@ajaxPhotoOrder) ?>?id=<?php echo $photos->getFirst()->getGalleryId()?>&'+order,
                                            {},
                                            function(data){
                                                    $("#pictures_list").html(data);
                                                    $('#working').hide();
                                            });
                            }
            });
            $( "#photos-list" ).disableSelection();
        });
    <?php } ?>

</script>
<?php if ($sf_user->hasFlash('ajax_notice')): ?>
  <div class="notice"><?php echo $sf_user->getFlash('ajax_notice') ?></div>
<?php endif ?>

<?php if ($sf_user->hasFlash('ajax_error')): ?>
  <div class="error"><?php echo $sf_user->getFlash('ajax_error') ?></div>
<?php endif ?>
<table border="0" width="100%" cellpadding="0" cellspacing="0" id="gallery_content">
    <tr>
        <th rowspan="3"></th>
        <th class="gallery_topleft"></th>
        <td id="gallery_tbl-border-top">&nbsp;</td>
        <th class="gallery_topright"></th>
        <th rowspan="3"></th>
    </tr>
    <tr>
        <td id="gallery_tbl-border-left"></td>
        <td>
            <!--  start content-table-inner ...................................................................... START -->
            <div id="gallery_content-table-inner">

                <!--  start table-content  -->
                <div id="gallery_table-content" style="min-height: 0px;">
                    <?php
                    $sizes = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_thumbnails_sizes");
                    foreach ($sizes as $i=>$size) {
                        if($size>50){
                            break;
                        }
                    }

                    if($photos->count() > 0){ ?>

                    <table id="maintable">
                            <tr>
                                <td style="width: 20%">
                                    <table class="mediumtable">
                                            <tr>
                                                <th rowspan="3"></th>
                                                <th class="topleft"></th>
                                                <td class="tbl-border-top">&nbsp;</td>
                                                <th class="topright"></th>
                                                <th rowspan="3"></th>
                                            </tr>
                                            <tr>
                                            <td class="tbl-border-left"></td>
                                            <td>
                                                <div style="text-align: center">
                                                    <img src="<?php echo sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_defaultPicture");?>"/>
                                                    <h1><?php echo __("backend.action.edit.title",array(),"sfmaug"); ?></h1>
                                                </div>
                                                <div class="photo_action_full" style="height: 150px"><?php echo __("backend.action.edit.help",array(),"sfmaug")?></div>
                                                <?php foreach( $photos as $i=>$photo ){
                                                    include_partial("gallery/actions", array("photo"=>$photo,"contextual"=>false));
                                                }?>
                                            </td>
                                            <td class="tbl-border-right"></td>
                                            </tr>
                                            <tr>
                                                <th class="bottomleft"></th>
                                                <td class="tbl-border-bottom">&nbsp;</td>
                                                <th class="bottomright"></th>
                                            </tr>
                                    </table>
                                </td>
                                <td id="photo_list">
                                    <table class="mediumtable">
                                            <tr>
                                                <th rowspan="3"></th>
                                                <th class="topleft"></th>
                                                <td class="tbl-border-top">&nbsp;</td>
                                                <th class="topright"></th>
                                                <th rowspan="3"></th>
                                            </tr>
                                            <tr>
                                            <td class="tbl-border-left"></td>
                                            <td>
                                                <ul id="photos-list">
                                                    <?php foreach( $photos as $i=>$photo ){ ?>
                                                        <li id="photo_elt_<?php echo $photo->getId()?>" class="photo-elt" style="float:left;list-style-type:none;min-width:100px;">
                                                        <div id="photo-<?php echo $photo->getId()?>" class="picture" onclick="$('.photo_action_full').hide(); $('#actions_<?php echo $photo->getId() ?>').toggle('slow',  showActionFull); " onmouseover="$(this).find('.actions #contextual_actions_<?php echo $photo->getId() ?>').show();" onmouseout="$(this).find('.actions #contextual_actions_<?php echo $photo->getId() ?>').hide();">
                                                            <?php if($photo->getIsDefault()){ ?> <div id="default" title="Cette photo est l'image utilisée pour la couverture de la galerie"></div><?php } ?>
                                                            <img class="basic" x-image-id="<?php echo $photo->getPhotoId() ?>" src="<?php echo $photo->getFullPicpath($size); ?>"/>
                                                          <div class="actions<?php echo $photo->getIsDefault()?" defaultPicture":"" ; ?>">
                                                              <?php include_partial("gallery/actions", array("photo"=>$photo,"contextual"=>true)); ?>
                                                          </div>
                                                        </div>
                                                            </li>
                                                    <?php } ?>
                                                </ul>
                                            </td>
                                            <td class="tbl-border-right"></td>
                                            </tr>
                                            <tr>
                                                <th class="bottomleft"></th>
                                                <td class="tbl-border-bottom">&nbsp;</td>
                                                <th class="bottomright"></th>
                                            </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    <?php }else{ ?>
                    <p><?php echo __("backend.gallery.nophotos",array(),"sfmaug") ?></p>
                    <?php } ?>
                </div>
                <!--  end table-content  -->

                <div class="clear"></div>

            </div>
            <!--  end content-table-inner ............................................END  -->
        </td>
        <td id="gallery_tbl-border-right"></td>
    </tr>
    <tr>
        <th class="gallery_sized bottomleft"></th>
        <td id="gallery_tbl-border-bottom">&nbsp;</td>
        <th class="gallery_sized bottomright"></th>
    </tr>
</table><br/>

