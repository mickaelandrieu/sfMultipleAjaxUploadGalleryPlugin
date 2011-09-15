<?php
/**
 *
 * @author lbernard
 */
interface Uploadable {
    public function getPath();
    public function getName();
    public function getSize();
    public function isMoved();
    public function setMoved();
}

?>
