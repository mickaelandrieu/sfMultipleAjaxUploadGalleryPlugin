<?php

/**
 * sfWidgetFormMAUGFileUpload represents an upload HTML input tag with the possibility
 * to upload several files
 *
 * @package    sfMultipleAjaxUploadGalleryPlugin
 * @subpackage widget
 * @author     Leny Bernard <leny.bernard@gmail.com>
 * @version    GIT: $Id: sfWidgetFormMAUGFileUpload.class.php 30762 2011-08-229 17:38:33Z leny $
 */
class sfWidgetFormMAUGFileUpload extends sfWidgetFormInput {

    /**
     * Constructor.
     *
     * Available options:
     *
     *  * callback:  give the route you want to call to upload the files
     *  * with_delete:  Whether to add a delete button or not
     *
     * @param array $options     An array of options
     * @param array $attributes  An array of default HTML attributes
     *
     * @see sfWidgetFormInput
     */
    protected function configure($options = array(), $attributes = array()) {
        parent::configure($options, $attributes);

        $this->setOption('type', 'file');
        $this->setOption('needs_multipart', true);

        $this->addOption('upload_method', null);
        $this->addOption('upload_config', 'default');
        $this->addOption('callback', null);
        $this->addOption('with_delete', true);
        $this->addOption('file_types', null);
        $this->addOption('help_message_1',null);
        $this->addOption('help_message_2',null);
        $this->addRequiredOption('parent_id');
        $this->addOption('button_label', "Upload");
        $this->addOption('uploaderTemplate', 'uploader/uploaderTemplate');
        $this->addOption('btn_template',"uploader/uploaderButtonTemplate");
}

    public function getStylesheets() {
        return array(
            "/sfMultipleAjaxUploadGalleryPlugin/css/fileuploader.css" => "all",
        );
    }

    public function getJavaScripts() {
        return array(
            "/sfMultipleAjaxUploadGalleryPlugin/js/fileuploader.js"
        );
    }

    /**
     * Renders the widget.
     *
     * @param  string $name        The element name
     * @param  string $value       The value displayed in this widget
     * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
     * @param  array  $errors      An array of errors for the field
     *
     * @return string An HTML tag string
     *
     * @see sfWidgetForm
     */
    public function render($name, $value = null, $attributes = array(), $errors = array()) {

        $file_types = $this->getOption('file_types') ? implode(",", $this->getOption('file_types')) : "all";
        if (!$this->getOption("callback")) {
            $callbackUrl = sfContext::getInstance()->getRouting()->generate(
                "uploader_list");
        }else{
            $callbackUrl = $this->getOption("callback");
        }

        if (!$this->getOption("upload_method")) {
            $uploadUrl = sfContext::getInstance()->getRouting()->generate(
                "uploader_upload");
        }else{
            $uploadUrl = $this->getOption("upload_method");
        }
        
        $upload_config = sfConfig::get("app_uploader_upload_config");
        
        $render = include_partial($this->getOption('uploaderTemplate'), array(
            "upload_config" => $this->getOption('upload_config'),
            "parent_id" => $this->getOption('parent_id'),
            "button_label" => $this->getOption('button_label'),
            "file_types" => $file_types,
            "id" => $this->generateId($name),
            "upload_method" => $uploadUrl,
            "callback" => $callbackUrl,
            "btn_template" => $this->getOption('btn_template'),
            "help_message1" => $this->getOption('help_message_1'),
            "help_message2" => $this->getOption('help_message_2'),
            ));
        return strtr($render, null, null);
    }

}
