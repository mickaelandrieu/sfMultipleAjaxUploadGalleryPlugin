<?php

/**
 * fileuploader actions.
 *
 * @package    uploader
 * @subpackage fileuploader
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UploaderActions extends sfActions {

    public function executeUpload(sfWebRequest $request) {
        $parent_id = $request->getParameter("parent_id");
        $file_types = explode(",",$request->getParameter("file_types"));
        $upload_config = $request->getParameter("upload_config");

        $upload_manager = new UploadManager($upload_config);
        $upload_manager->bind($file_types);
        $errors = $upload_manager->save($parent_id);
        $success = !count($errors) ? true : false;
        $array = array(
                  "success"=> $success,
                  "message"=> is_array($errors)? implode(",",$errors):""
            );
        return $this->renderText(json_encode($array));
    }
    
    public function executeList(sfWebRequest $request){
        $this->parent_id = $request->getParameter("parent_id");
        $this->file_types = $request->getParameter("file_types");
    }

}
