<?php

class Doctrine_Template_Listener_Gallerify extends Doctrine_Record_Listener
{

  public function __construct($options = array())
  {
    $this->_options = $options;
  }
}