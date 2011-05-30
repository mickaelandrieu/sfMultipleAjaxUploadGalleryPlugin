<ul class="sf_admin_actions">
<?php if ($form->isNew()): ?>
  <?php echo $helper->linkToDelete($form->getObject(), array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Back to list',)) ?>
  <?php echo $helper->linkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>
  <?php echo $helper->linkToSaveAndAdd($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save_and_add',  'label' => 'Save and add',)) ?>
<?php else: ?>
  <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Back to list',)) ?>
  <?php echo $helper->linkToDelete($form->getObject(), array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  <li class="sf_admin_action_purge">
<?php if (method_exists($helper, 'linkTo_purge')): ?>
  <?php echo $helper->linkTo_purge($form->getObject(), array(  'name' => 'purge',  'action' => 'purge',  'params' =>   array(  ), 'confirm' => __('backend.action.edit.purge.confirmation',array(),"sfmaug"),  'class_suffix' => 'purge',  'label' => __('backend.action.edit.purge',array(),"sfmaug"))) ?>
<?php else: ?>
  <?php echo link_to(__('backend.action.edit.purge',array(),"sfmaug"), 'gallery/purge?id='.$gallery->getId(), array('confirm' => __('backend.action.edit.purge.confirmation',array(),"sfmaug"))) ?>
<?php endif; ?>
  </li>
  <?php echo $helper->linkToSave($form->getObject(), array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>
<?php endif; ?>
</ul>
