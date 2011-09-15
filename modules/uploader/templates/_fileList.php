<?php
foreach($files as $i=>$file){
    switch ($file->getTypefichier()) {
        case "Images":
            $src = $file->getFullPath();
            break;
        case "Audio":
            $src = "/eUploaderPlugin/images/icons/audio.png";
            break;
        case "Vidéo":
            $src = "/eUploaderPlugin/images/icons/video.png";
            break;
        case "Text":
            $src = "/eUploaderPlugin/images/icons/document.png";
            break;

        default:
            break;
    }?>
    <img src="<?php echo $src ?>"/>
<?php
}
?>
