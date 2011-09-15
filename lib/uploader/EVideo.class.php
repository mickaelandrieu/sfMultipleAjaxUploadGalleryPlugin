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
    
}

?>
