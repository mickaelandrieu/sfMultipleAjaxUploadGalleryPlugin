<?php
/**
 * Description of EAudio
 *
 * @author lbernard
 */
class EAudio extends BaseEMedia {
    protected $_type = "Audio";

    public function isValid() {
        if (parent::isValid()) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>
