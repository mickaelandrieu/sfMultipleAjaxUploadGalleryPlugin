<?php 
if(count($gallery->getPhotos())){
    foreach ($slideshowOptions as $name=>$option) {
        $options[$name] = $option;    
    }
    $options["gallery"] = $gallery;
    include_partial("slideshow/".$slideshowOptions['template'], $options) ; 
}
?>