<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of utils
 *
 * @author leny
 */
class SfMaugUtils {
    static public function slugify($text) {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    static public function light_image($thumb_url, $image_url, $image_link_options = array(), $thumb_options = array() )
    {
      //make lightbox effect
      $thumb_tag = image_tag($thumb_url, $thumb_options);

      $image_link_options['class'] = isset($image_link_options['class']) ? $image_link_options['class']." lightbox" : 'lightbox';

      echo link_to($thumb_tag, $image_url, $image_link_options);
    }

    static public function light_image_activate()
    {
      if (!sfContext::hasInstance()) return;

      //add resources
      $response = sfContext::getInstance()->getResponse();

      //check if jqueryreloaded plugin is activated
      if (sfConfig::has('sf_jquery_web_dir') && sfConfig::has('sf_jquery_core'))
        $response->addJavascript(sfConfig::get('sf_jquery_web_dir'). '/js/'.sfConfig::get('sf_jquery_core'));
      else
        throw new Exception("Theres is no JqueryReloaded plugin !");

      //JQuery Lightbox specific
      $response->addJavascript(sfConfig::get("app_sf_jquery_lightbox_js_dir").'jquery.lightbox-0.5.js');
      $response->addStylesheet(sfConfig::get("app_sf_jquery_lightbox_css_dir").'jquery.lightbox-0.5.css');

      $code = "$(function() {
        $('a.lightbox').lightBox({
          imageLoading: '".sfConfig::get('app_sf_jquery_lightbox_imageLoading')."',
          imageBtnClose: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnClose')."',
          imageBtnPrev: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnPrev')."',
          imageBtnNext: '".sfConfig::get('app_sf_jquery_lightbox_imageBtnNext')."',
          imageBlank: '".sfConfig::get('app_sf_jquery_lightbox_imageBlank')."',
          txtImage: '".sfConfig::get('app_sf_jquery_lightbox_txtImage')."',
          txtOf: '".sfConfig::get('app_sf_jquery_lightbox_txtOf')."' });
      });";

      echo javascript_tag($code);
    }

    static public function gallery_path($gallery = '')
    {
        $uploadDir = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery");
        $webDir = sfConfig::get("sf_web_dir");
        $upload_gallery_path = substr($uploadDir, strlen($webDir), strlen($uploadDir) - strlen($webDir));
        $upload_gallery_path = str_replace( '\\', '/', $upload_gallery_path);
        return $upload_gallery_path;
    }

    /*@PARAMS : $permissions = 'drwxr-xr-x';
     */
    public static function getChmodValue($permissions) {
      $mode = 0;

      if ($permissions[1] == 'r') $mode += 0400;
      if ($permissions[2] == 'w') $mode += 0200;
      if ($permissions[3] == 'x') $mode += 0100;
      else if ($permissions[3] == 's') $mode += 04100;
      else if ($permissions[3] == 'S') $mode += 04000;

      if ($permissions[4] == 'r') $mode += 040;
      if ($permissions[5] == 'w') $mode += 020;
      if ($permissions[6] == 'x') $mode += 010;
      else if ($permissions[6] == 's') $mode += 02010;
      else if ($permissions[6] == 'S') $mode += 02000;

      if ($permissions[7] == 'r') $mode += 04;
      if ($permissions[8] == 'w') $mode += 02;
      if ($permissions[9] == 'x') $mode += 01;
      else if ($permissions[9] == 't') $mode += 01001;
      else if ($permissions[9] == 'T') $mode += 01000;

      return $mode;
    }
}
?>
