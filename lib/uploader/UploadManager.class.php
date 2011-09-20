<?php

class UploadManager {

    private $upload_config;
    private $suffix = "";
    private $mediaObject;
    private $errors = array();

    function __construct($upload_config) {
        $fullConfig = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_uploader");
        $this->upload_config = $fullConfig[$upload_config];
    }

    public function bind($file_types) {

        /* Récupérer le fichier à uploader et créer un media object du bon type */
        //Get the allowed extensions
        
        //expect one or several of the files you set in app config file
        
        if($file_types[0] == "all") $file_types = $this->upload_config['entity_file_kinds'];
        foreach($file_types as $file_type){
            $mimesExtensions[strtolower($file_type)] = $this->upload_config[strtolower($file_type)."_allowed_extensions"];
        }
        $this->mediaObject = EMediaFactory::getMediaObject($mimesExtensions,$this->upload_config);
        if (!$this->mediaObject) {
            $extensions = array();
            foreach ($mimesExtensions as $ext) {
                $extensions = array_merge($extensions, $ext);
            }
            $this->errors[] = "Le fichier \"" . $_GET["qqfile"] . "\" n'est pas pris en charge.<br/>
              Vous pouvez envoyer ce type de fichiers " . implode(", ", $extensions);
        }
    }

    public function save($parent_id) {
        if($this->mediaObject){
                $this->mediaObject->setParentId($parent_id);
            $this->uploader = new qqFileUploader($this->mediaObject->getAllowedExtensions(), $this->mediaObject->getLimitMax());
            $size = $this->uploader->getSize();
            $this->mediaObject->setSize($size);
            if ($this->mediaObject->isValid()) {
                $entity = $this->mediaObject->save();
                $response = $this->upload();
                if(is_array($response)){
                    $this->errors[] = implode(", ",$response);
                }else{
                    $entity->{"set".$this->upload_config[strtolower($this->mediaObject->getType())."_filename_column"]}($response);
                    $entity->save();
                }
            }else{
                $this->errors = array_merge($this->errors, $this->mediaObject->getErrors());
            }
        }
        return $this->errors;
    }

    public function upload() {
        $upload_dir = $this->mediaObject->getPath();
        if (!is_dir($upload_dir))
            mkdir($upload_dir, 0777, true);
        return $this->uploader->handleUpload($upload_dir);
    }

}

?>
