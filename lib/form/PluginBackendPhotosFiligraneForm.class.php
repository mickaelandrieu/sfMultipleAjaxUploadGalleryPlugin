<?php
class PluginBackendPhotosFiligraneForm extends sfForm
{

    public function setup()
    {
      $choices = array(
          'top-left' => 'top-left',
          'bottom-left' => 'bottom-left',
          'left' => 'left',
          'right' => 'right',
          'top-right' => 'top-right',
          'bottom-right' => 'bottom-right',
          'bottom-center' => 'bottom-center',
          'center' => 'center',
          'middle-left' => 'middle-left',
          'middle-right' => 'middle-right',
          'bottom-left' => 'bottom-left'
      );


        $this->setWidgets(array(
          'position'	=> new sfWidgetFormChoice(array(
                              'expanded' => true,
                              'choices'  => $choices,
                            )),
        ));

        $this->setValidators(array(
          'position'  => new sfValidatorChoice(array('required' => false, 'choices'  => $choices)),
        ));

        $this->widgetSchema->setNameFormat('filigrane[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    }

}
?>