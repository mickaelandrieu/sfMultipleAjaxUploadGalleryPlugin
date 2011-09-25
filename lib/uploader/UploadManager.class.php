<?php

class UploadManager {

    private $upload_config;
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
            $filesExtensions[strtolower($file_type)] = $this->upload_config[strtolower($file_type)."_allowed_extensions"];
        }
        $this->mediaObject = EMediaFactory::getMediaObject($filesExtensions,$this->upload_config);
        if (!$this->mediaObject) {
            $extensions = array();
            foreach ($filesExtensions as $ext) {
                $extensions = array_merge($extensions, $ext);
            }


	    //Get the file

            $file = $_GET["qqfile"];
            if ($file == "")
            $file = $_FILES['qqfile']['name'];
            $this->errors[] = "Le fichier \"" . $file . "\" n'est pas pris en charge.<br/>
              Vous pouvez envoyer ce type de fichiers " . implode(", ", $extensions);
        }
    }

    /* Will save the media object and to stuff on it : 
     *      - rename if a file already exists
     *      - convert a video for example
     *      - create thumbnails
     */
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
					if(array_key_exists($this->mediaObject->getType()."_convert_types", $this->upload_config))
                        {
                            $convertExtensions = $this->upload_config[$this->mediaObject->getType()."_convert_types"];
                            $response = $this->mediaObject->convert(
                                    $response,
                                    sfConfig::get("sf_web_dir") . $this->mediaObject->getPath() . "/",
                                    $convertExtensions);
                        }
                    //example : $entity->setFileName("file.jpg");
                    $methodName = SfMaugUtils::camelize("set".$this->upload_config["entity_filename_column"]);
                    $entity->$methodName($response);
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
