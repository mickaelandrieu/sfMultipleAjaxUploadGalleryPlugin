<?php
/**
 * Description of EText
 *
 * @author lbernard
 */
class EText extends BaseEMedia {
    protected $_type = "Text";

    public function isValid() {
        if (parent::isValid()) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>
