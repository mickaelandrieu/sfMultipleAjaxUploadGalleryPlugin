<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseEMedia
 *
 * @author lbernard
 */
class BaseEMedia implements Uploadable {

    private $_isMoved;
    private $_path;
    private $_size;
    private $_name;
    private $_limit_max;
    private $_allowed_extensions;
    private $_parent_id;
    protected $errors = array();

    public function __construct($type,$name,$config) {
        $this->_name = $name;
        $this->config = $config;
        $this->_type = $type;
        $this->_allowed_extensions = $config[strtolower($type)."_allowed_extensions"];
        $this->_limit_max = $config[strtolower($type)."_unit_max_weight"];
    }

    public function save() {
        /** Save the file in the correct table in db */
        if($this->config['relation_type']=="enum"){
            $className = $this->config['entity_class_name'];
            $entity->{SfMaugUtils::camelize("set".$this->config['entity_column_name'])}($this->getType());
        }else{
            $className = ucfirst($this->type);
            $entity = new $className();
        }
        
        $entity->$this->config[$this->type."_filename_column"]($this->getName());
        $entity->{SfMaugUtils::camelize("set".$this->config['entity_aggregate_columnid'])}($this->getParentId());
        $entity->{SfMaugUtils::camelize("set".$this->config[$this->type."_size_column"])}($this->getSize());
        $this->setPath($entity->getPath());
        $entity->save();
        return $entity;
    }

    public function isValid() {
        //test extension
        //test size
        if($this->config['relation_type']=="enum"){
            $className = $this->config['entity_class_name'];
            $entity->{"set".$this->config['entity_column_name']}($this->getType());
        }else{
            $className = ucfirst($this->type);
            $entity = new $className();
        }
        
        $fullSize = $this->getSize();
        $files = Doctrine::getTable($className)->createQuery("f")->where("f.".$this->config['entity_column_name']." = ?",$this->getParentId())->execute();
        foreach ($files as $file) {
            $fullSize+=$file->{SfMaugUtils::camelize("get".$this->config[$this->type."_size_column"])}();
        }
        if( $files->count() > $this->config[strtolower($this->getType())."_max_number"]){
            $this->errors[] = "Vous avez atteint la limite de fichiers uploadés, tous types de fichiers confondus. Max (" . ceil($this->config["global_max_weight"] / (1024 * 1024)) . "Mo)";
        }elseif( $fullSize > $this->config["global_max_weight"]){
            $this->errors[] = "Vous avez atteint la limite de fichiers uploadés, tous types de fichiers confondus. Max (" . ceil($this->config["global_max_weight"] / (1024 * 1024)) . "Mo)";
        }elseif( $fullSize > $this->config[strtolower($this->getType())."_max_weight"]){
            $this->errors[] = "Vous avez atteint la limite de fichiers uploadés pour ce type de fichier. Max (" . ceil($this->config["global_max_weight".strtolower($this->getType())."_max_weight"] / (1024 * 1024)) . "Mo)";
        }else{
            if (!preg_match("/\.(" . implode("|", $this->getAllowedExtensions()) . ")$/", strtolower($this->getName())))
                $this->errors[] = "Ce type de fichier n'est pas autorisé";
            if ($this->getSize() > $this->getLimitMax()) {
                $this->errors[] = "Ce fichier est trop volumineux. Max (" . ceil($this->getLimitMax()  / (1024 * 1024)) . "Mo)";
            }
        }
        return empty($this->errors) ? true : false;
    }

    public function getPath() {
        return $this->_path;
    }

    public function setPath($path) {
        $this->_path = $path;
    }

    public function getName() {
        return $this->_name;
    }

    public function isMoved() {
        return $this->_isMoved;
    }

    public function setMoved() {
        $this->_isMoved = true;
    }

    public function getSize() {
        return $this->_size;
    }

    public function setSize($size) {
        $this->_size = $size;
    }

    public function setName($name) {
        $this->_name = $name;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getType() {
        return $this->_type;
    }

    public function getLimitMax() {
        return $this->_limit_max;
    }

    public function setLimitMax($limitMax) {
        $this->_limit_max = $limitMax;
    }

    public function getAllowedExtensions() {
        return $this->_allowed_extensions;
    }

    public function setAllowedExtensions(Array $extensions) {
        $this->_allowed_extensions = $extensions;
    }

    public function getParentId() {
        return $this->_parent_id;
    }

    public function setParentId($parent_id) {
        $this->_parent_id = $parent_id;
    }

}

?>
