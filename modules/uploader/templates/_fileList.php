<?php
if($upload_config['relation_type'] == "related_table"){
    // files = array(
    //              Photos = Doctrine_Collection
    //              Pdf = Doctrine_Collection
    
    $fileCollection = array();
    foreach($files as $doctrineFileCollection){
        foreach($doctrineFileCollection as $file){
            $files[] = $file;
            switch(get_class($file)){
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
                        $src = "/sfMultipleAjaxUploadGalleryPlugin/images/files/file.png";
                        break;
            }?> 
            <img src="<?php echo $src ?>"/> 
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

