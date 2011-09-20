<?php

/**
 * PluginPhotos
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    sfMultipleAjaxUploadGalleryPlugin
 * @subpackage model
 * @author     leny
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginPhotos extends BasePhotos
{
    public static function colorizeDefaultChoice($onclick)
    {
        $list = array('radio' => array(
                        array('name' => 'list_color', 'value' => '704214', 'id' => 'sepia', 'label' => 'sepia', 'onclick' => $onclick),
                        array('name' => 'list_color', 'value' => 'FFE5B4', 'id' => 'peach', 'label' => 'peach', 'onclick' => $onclick)
                    ));
        return $list;
    }
    public function getFullPicpath($size = false)
    {
        $path = SfMaugUtils::gallery_path().$this->getGallery()->getSlug()."/";
        if ($size) {
            $path .= $size."/";
        }
        return $path.$this->getPicpath();
    }
    public function getPath()
    {
        return sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug()."/";
    }

    public function getPhotoId()
    {
        return $this->getPrimaryKey();
    }

    public function getFullPicpathDefault()
    {
        $defaultSize = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_default_size");
        return $this->getFullPicpath($defaultSize);
    }

    public function update(Doctrine_Connection $conn = null)
    {
        parent::save($conn);
    }

    public function save(Doctrine_Connection $conn = null)
    {
        parent::save($conn);

        $filename = $this->getPicpath();
        if(file_exists(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery")."tmp/".$filename)){
            copy (
                    sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery")."tmp/".$filename,
                    sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug()."/".$filename );
                chmod(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug()."/".$filename,SfMaugUtils::getChmodValue("drwxrwxrwx"));
        }

        if(file_exists($this->getPath().$this->getPicpath())){
            $this->create_thumbnails();
        }
    }

  /**
   * Listens to the photos.create_thumbnails event.
   *
   * @param sfEvent An sfEvent instance
   * @static
   */
    static public function create_thumbnails_task(sfEvent $event){
        $data = $event->getParameters("data");
        $data['photos']->create_thumbnails();
        
    }

    public function create_thumbnails()
    {
        $img = new sfImage(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug().'/'.$this->getPicpath(), 'image/'.$this->getExtension());
        $w = $img->getWidth();
        $h = $img->getHeight();
        $sizes = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_thumbnails_sizes");
        if(in_array(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_default_size"),$sizes)) {
            $sizes[] = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_default_size");
        }
        arsort($sizes,SORT_DESC);
        foreach($sizes as $size) {
            if(is_numeric($size))
            {
                $x = (int)($w/$h*$size);
                $img->resize($x,$size);
                $img->setQuality(100);
                $dir = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug().'/'.$size;
                if (!is_dir($dir)) {
                    mkdir ($dir);
                    chmod($dir,SfMaugUtils::getChmodValue("drwxrwxrwx"));
                }
                $img->saveAs($dir.'/'.$this->getPicpath(), 'image/'.$this->getExtension());
                chmod($dir.'/'.$this->getPicpath(),SfMaugUtils::getChmodValue("drwxrwxrwx"));
            }
        }
    }

    public function  delete(Doctrine_Connection $conn = null)
    {
        parent::delete($conn);
        $filename = $this->getPicpath();

        unlink(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug().'/'.$filename);
        foreach (sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_thumbnails_sizes") as $size) {
            unlink(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery").$this->getGallery()->getSlug().'/'.$size.'/'.$filename);
        }
    }

    public function isDefault()
    {
        return (bool) $this->getIsDefault();
    }

    public function crop($left, $top, $width, $height, $quality=100)
    {
        return $this->treatmentPhotos('sfImageCropGD', 'sfImageCropImageMagick', $left, $top, $width, $height);
    }

    public function getExtension()
    {
        $extension = explode(".",  $this->getPicpath());
        $extension = strtolower($extension[count($extension)-1]);
        return $extension = $extension == "jpg" ? "jpeg" : $extension;
    }

    public function rotate($degree, $quality=100)
    {
        return $this->treatmentPhotos('sfImageRotateGD', 'sfImageRotateImageMagick', $degree);
    }

    public function overlay($position = 'top-left')
    {
        $uploadDir = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_gallery");
        $picpath = $uploadDir.$this->getGallery()->getSlug()."/".$this->getPicpath();
        $float = 45;
        $img = new sfImage($picpath, 'image/'.$this->getExtension());
        $overlay = new sfImage(sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_path_filigrane"), 'image/png');
        $adapter = sfConfig::get("app_sfImageTransformPlugin_default_adapter");
        if ($adapter == "GD") {
            $opacity = new sfImageOpacityGD($float);
            $opacity->execute($overlay);
            $overlay = new sfImageOverlayGD($overlay, $position);
        } elseif ($adapter == "ImageMagick") {
            $opacity = new sfImageOpacityImageMagick($float);
            $opacity->execute($overlay);
            $overlay = new sfImageOverlayImageMagick($overlay);
        }
        $overlay->execute($img);

        $picpathanalyse = explode("_",$this->getPicpath());
        if (count($picpathanalyse)>0 && is_numeric($picpathanalyse[0])) {
            $picpath_orig = "";
            foreach ($picpathanalyse as $key => $value) {
                if($key!=0){
                    $picpath_orig .= "_".$value;
                }
            }
            $key = intval($picpathanalyse[0])+1;
            $this->setPicpath($key.$picpath_orig);
        } else {
            $this->setPicpath("1_".$this->getPicpath());
        }

        $picpath = $uploadDir.$this->getGallery()->getSlug()."/".$this->getPicpath();
        $ok = $img->saveAs($picpath, 'image/'.$this->getExtension());
        if ($ok) {
            $this->create_thumbnails();
            $this->save();
        }
        return $ok;
    }

    public function colorize($red, $green, $blue, $alpha = 0, $quality=100)
    {
        return $this->treatmentPhotos('sfImageColorizeGD', 'sfImageColorizeImageMagick', $red, $green, $blue, $alpha);
    }

    public function greyScale($quality=100)
    {
        return $this->treatmentPhotos('sfImageGreyscaleGD', 'sfImageGreyscaleImageMagick');
    }

    public function flip($quality=100)
    {
        return $this->treatmentPhotos('sfImageMirrorGD', 'sfImageMirrorImageMagick');
    }

    public function flipV($quality=100)
    {
        return $this->treatmentPhotos('sfImageFlipGD', 'sfImageFlipImageMagick');
    }

    public function brightness($brigthness, $quality=100)
    {
        return $this->treatmentPhotos('sfImageBrightnessGD', 'sfImageBrightnessImageMagick', $brigthness);
    }

    public static function rgb2hex2rgb($c)
    {
        if (!$c) {
            return false;
        }
        $c = trim($c);
        $out = false;
        if(preg_match("/^[0-9ABCDEFabcdef\#]+$/i", $c)) {
            $c = str_replace('#','', $c);
            $l = strlen($c) == 3 ? 1 : (strlen($c) == 6 ? 2 : false);

            if ($l) {
                unset($out);
                $out[0] = $out['r'] = $out['red'] = hexdec(substr($c, 0,1*$l));
                $out[1] = $out['g'] = $out['green'] = hexdec(substr($c, 1*$l,1*$l));
                $out[2] = $out['b'] = $out['blue'] = hexdec(substr($c, 2*$l,1*$l));
            } else {
                $out = false;
            }

        } elseif (preg_match("/^[0-9]+(,| |.)+[0-9]+(,| |.)+[0-9]+$/i", $c)) {
            $spr = str_replace(array(',',' ','.'), ':', $c);
            $e = explode(":", $spr);
            if (count($e) != 3){
                return false;
            }
            $out = '#';
            for($i = 0; $i<3; $i++) {
                $e[$i] = dechex(($e[$i] <= 0)?0:(($e[$i] >= 255)?255:$e[$i]));
            }
            for($i = 0; $i<3; $i++) {
                $out .= ((strlen($e[$i]) < 2)?'0':'').$e[$i];
            }
            $out = strtoupper($out);
        } else {
            $out = false;
        }
        return $out;
    }

    public function treatmentPhotos()
    {
        $numargs = func_num_args();
        if ($numargs < 2) {
            $this->getUser()->setFlash('error', 'Error execution method');
            return false;
        }
        $arg_list = func_get_args();
        //argument 0
        $classGD = array_shift($arg_list);
        if (!class_exists($classGD)) {
            $this->getUser()->setFlash('error', 'Error execution method');
            return false;
        }
        //argument 1
        $classImageMagick = array_shift($arg_list);
        if (!class_exists($classImageMagick)) {
            $this->getUser()->setFlash('error', 'Error execution method');
            return false;
        }

        $picpath = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$this->getFullPicpath();
        $img = new sfImage($picpath, 'image/'.$this->getExtension());
        $adapter = sfConfig::get("app_sfImageTransformPlugin_default_adapter");
        if($adapter == "GD"){
            if (method_exists($classGD,$f='__construct')) {
                $class = new ReflectionClass($classGD);
                $obj = $class->newInstanceArgs($arg_list);
            } else {
                $obj = new $classGD();
            }

        }elseif($adapter == "ImageMagick"){
            if (method_exists($classImageMagick,$f='__construct')) {
                $class = new ReflectionClass($classImageMagick);
                $obj = $class->newInstanceArgs($arg_list);
            } else {
                $obj = new $classImageMagick();
            }

        } else {
            $this->getUser()->setFlash('error', 'Error execution method');
            return false;
        }
        $obj->execute($img);

        $picpathanalyse = explode("_",$this->getPicpath());
        if (count($picpathanalyse)>0 && is_numeric($picpathanalyse[0])) {
            $picpath_orig = "";
            foreach ($picpathanalyse as $key => $value) {
                if($key!=0){
                    $picpath_orig .= "_".$value;
                }
            }
            $key = intval($picpathanalyse[0])+1;
            $this->setPicpath($key.$picpath_orig);
        }else{
            $this->setPicpath("1_".$this->getPicpath());
        }
        $picpath = sfConfig::get('sf_web_dir').DIRECTORY_SEPARATOR.$this->getFullPicpath();
        $ok = $img->saveAs($picpath, 'image/'.$this->getExtension());
        if($ok) {
            $this->create_thumbnails();
            $this->save();
        }
        return $ok;
    }

    public function getListPicPath($picpath_orig)
    {
        $path = array();
        $dir = dirname($this->getFullPicPath());
        $thisdir = sfConfig::get('sf_web_dir').$dir;
        if ($dircont = scandir($thisdir)) {
            $i=0;
            while (isset($dircont[$i])) {
                if ($dircont[$i] !== '.' && $dircont[$i] !== '..') {
                    $current_file = "{$thisdir}/{$dircont[$i]}";
                    if (is_file($current_file) && strpos($dircont[$i], $picpath_orig) !== false) {
                        $path[] = "{$dircont[$i]}";
                    }
                }
                $i++;
            }
        }
        return $path;
    }

    public function  getGallery() {
        return Doctrine_Query::create()
                ->from('Gallery g')
//                ->leftJoin('g.Translation t WITH t.lang = ?', sfContext::getInstance()->getUser()->getCulture())
                ->where('g.id = ?',$this->getGalleryId())->fetchOne();
    }
    
    /**
     * Fucking sfOutputEscaperIteratorDecorator
     * @return type 
     */
    public function getClassName(){
        return "Photos";
    }

}
