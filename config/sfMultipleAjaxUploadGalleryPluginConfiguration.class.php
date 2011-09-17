<?php
/**
 * sfMultipleAjaxUploadGalleryPlugin configuration class. Adds listeners
 * @author: leny bernard
 */
class sfMultipleAjaxUploadGalleryPluginConfiguration extends sfPluginConfiguration
{
   
  public function initialize()
  {
    $this->dispatcher->connect('sfMaug.create_thumbnail', array('photos', 'create_thumbnails_task'));
  }
}