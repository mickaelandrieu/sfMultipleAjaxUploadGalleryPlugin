<div id="files_list_<?php echo $parent_id; ?>">
<?php
if($upload_config['relation_type'] == "related_table"){
    // files = array(
    //              Photos = Doctrine_Collection
    //              Pdf = Doctrine_Collection
    
    $fileCollection = array();
    foreach($files as $doctrineFileCollection){
        foreach($doctrineFileCollection as $file){
            switch($file->getClassName()){
                case "Images":
                case "Photos":
                case "Picture":
                case "Image":
                case "Photo":
                        $src = $file->getFullPicpath(50);
                        $srcLarge = $file->getFullPicpath();
                        $params = "class=fancybox rel=gallery";
                        break;
                    case "Audio":
                        $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/audio.png";
                        break;
                    case "Vidéo":
                        $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/video.png";
                        break;
                    case "Text":
                        $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/document.png";
                        break;
                    default:
                        $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/file.png";
                        break;
            }?> 
                <?php if(!empty($srcLarge)){ ?>
                    <a href="<?php echo $srcLarge ?>" <?php echo $params; ?>><?php } ?>
                        <img src="<?php echo $src ?>"/> 
                <?php if(!empty($srcLarge)){ ?>
                    </a><?php } ?>
        <?php
        }
    }
    
    
    
    //merge vers un seul array contenant tous les objets 
}elseif($upload_config['relation_type'] == "enum"){
    foreach($files as $i=>$file){
        switch ($file->{"get".SfMaugUtils::camelize($upload_config['entity_column_name'])}()) {
                case "Images":
                case "Photos":
                case "Picture":
                case "Image":
                case "Photo":
                $src = $file->getFullPath();
                break;
            case "Audio":
                $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/audio.png";
                break;
            case "Vidéo":
                $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/video.png";
                break;
            case "Text":
                $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/document.png";
                break;

            default:
                break;
        }?> 
        <img src="<?php echo $src ?>"/> 
    <?php
    }
}
?>
</div>

<script>
    $(document).ready(function(){
        $('#files_list_<?php echo $parent_id; ?> a.fancybox-gallery').attr('rel', 'gallery').fancybox();
    });
</script>