<?php
/**
 * Description of EMediaFactory
 *
 * @author lbernard
 */
class EMediaFactory {
    
    public static function getMediaObject($mimesExtensions,$config){
        $object = null;
        foreach($mimesExtensions as $type=>$extensions){
            //Construct the regex to check the extension
            ${$type."regex"} = "/\.".implode("|",$extensions)."$/";

	    //Get the file

            $file = $_GET["qqfile"];
            if ($file == "")
            $file = $_FILES['qqfile']['name'];
            
	    //check the extension
            
            if(preg_match(${$type."regex"},strtolower($file))){
                //EImage, EAudio, EVideo, EDocument
                $mediaClass = class_exists("E".ucfirst($type))?"E".ucfirst($type):"BaseEMedia";
                //entity type definition from the config
                
                $object = new $mediaClass(ucfirst($type),$file,$config);
            }
        }
        
        return $object;
    }
        
}

?>
