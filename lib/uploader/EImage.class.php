<?php

/**
 * Description of EImage
 *
 * @author lbernard
 */
class EImage extends BaseEMedia {

    protected $_type = "Image";

    public function isValid() {
        if (parent::isValid()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
