<div id="<?php echo $id ?>files_list" class="sf_admin_form_row">
  <?php echo get_component('uploader','fileList', array('parent_id' => $parent_id,'file_types'=>$file_types, 'upload_config' => $upload_config)) ?>
</div>

<div id="<?php echo $id ?>" class="uploader-btn"><?php echo 'Ajouter des fichiers' ?></div>
<!--List Files-->
<ul id="<?php echo $id ?>files" ></ul>
<div class="clear"></div>

<script>
    function createUploader(id){
    var <?php echo $id."uploader" ?> = new qq.FileUploader({
            element: document.getElementById("<?php echo $id ?>"),
            template: "<?php echo addslashes(get_partial("uploader/uploaderButtonTemplate",array("button_label"=>$button_label))) ?>",
            action: "<?php echo $upload_method ?>",
            params:
                {
                        upload_config: "<?php echo $upload_config; ?>",
                        parent_id: <?php echo $parent_id; ?>,
                        file_types: "<?php echo $file_types; ?>"
                },
            onComplete: function(id, file, responseJson){
                    $.post("<?php echo $callback ?>",
                    {
                        upload_config: "<?php echo $upload_config; ?>",
                        parent_id: <?php echo $parent_id; ?>,
                        file_types: "<?php echo $file_types; ?>"
                    },

                    function(data)
                    {
                        $("#<?php echo $id ?>files_list").html(data);
                        $("#<?php echo $id ?>status").removeClass("loading");
                        $("#<?php echo $id ?>status").addClass("success");
                    });
                    
                },
            onSubmit: function(id, fileName){
                },
            onProgress: function(id, fileName){
                    $("#<?php echo $id ?>status").addClass("success");
                    $("#<?php echo $id ?>status").addClass("loading");
                }
            });
            
    }
    window.onload = createUploader("<?php echo $id ?>");
</script>