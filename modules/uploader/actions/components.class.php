<?php

/**
 * Description of uploaderComponents
 *
 * @author lbernard
 */

class uploaderComponents extends sfComponents {

    public function executeFileList()
    {
        $fullConfig = sfConfig::get("app_sfMultipleAjaxUploadGalleryPlugin_uploader");
        $this->upload_config = $fullConfig[$this->upload_config];
        $this->files = array();
        if($this->upload_config['relation_type'] == 'related_table'){
            if(!is_array($this->type)) $this->types = $this->upload_config['entity_file_kinds'];
            foreach($this->types as $type){
                $this->files['type'] = Doctrine::getTable(ucfirst($type))->createQuery('f')
                        ->where('f.'.$this->upload_config['entity_aggregate_columnid'].' = ?',$this->parent_id)
                        ->execute();
            }
            
        }elseif($this->upload_config['relation_type'] == 'enum'){
            throw new Exception('Le système ne gère pas encore ce cas');
//            $query = Doctrine::getTable($this->upload_config["aggregate_entity_class_name"])
//                    ->createQuery("g")
//                    ->where('g.id=?',$this->parent_id);
//            if(is_array($this->type)){
//            $this->files = $query->andWhereIn("pf.typefichier ",  array_values(array_intersect_key($map, array_flip(explode(",",$this->file_types)))))
//                    ->execute();
//            }
            
        }elseif($this->upload_config['relation_type'] == 'enum'){
            
        }
    }

}
?>
