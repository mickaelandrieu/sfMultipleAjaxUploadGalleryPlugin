<?php
/**
 * Description of EVideo
 *
 * @author lbernard
 */
class EVideo extends BaseEMedia {
    protected $_type = "Vidéo";

    public function isValid() {
        if (parent::isValid()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function convert($newFileName,$path,$convertExtensions=array()) {
        $this->entity->setNomFichier($newFileName);
        $newFileName = preg_replace("/\.[a-z]+$/",".mp4",$this->entity->getNomFichier());
        $poster = preg_replace("/\.[a-z]+$/","1.jpg",$this->entity->getNomFichier());
        if(!preg_match("/(mp4|m4v)$/",$this->entity->getNomFichier())){
            foreach($convertExtensions as $extension){
                if(is_file("/usr/bin/HandBrakeCLI")){
                    exec('/usr/bin/HandBrakeCLI -i "'.  $path.$this->entity->getNomFichier().'"  -o "'.$path.$newFileName.'" -e x264 -m -x ref=2:bframes=2:subme=6:mixed-refs=0:weightb=0:8x8dct=0:trellis=0');
                }else{
                    exec("ffmpeg -i ".  $path.$this->entity->getNomFichier()." -f psp -r 29.97 -b 768k -ar 24000 -ab 64k -s 800x600 ".$path.$newFileName);
                }
                exec("ffmpeg ".  $path.$this->entity->getNomFichier()." -i ".$path.$poster);
            }
            $this->entity->setNomFichier($newFileName);
        }
        return $newFileName;
    }
    
}

?>
