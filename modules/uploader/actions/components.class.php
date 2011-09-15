<?php

/**
 * Description of uploaderComponents
 *
 * @author lbernard
 */

class uploaderComponents extends sfComponents {

    public function executeFileList()
    {
        $map = array("audio"=>"Audio", "image"=>"Images", "video"=>"Vidéo", "application"=>"Text");
        $this->files = Doctrine::getTable("ProfileFichiers")->createQuery("pf")
                ->where("pf.profileid = ? ",$this->parent_id)
                ->andWhereIn("pf.typefichier ",  array_values(array_intersect_key($map, array_flip(explode(",",$this->mime_types)))))
                ->execute();
    }

}
?>
