<?php
namespace Drupal\mydata\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;

class DeleteForm extends ConfirmFormBase {

public function getFormId() {
return 'delete_form';
}

public $cid;
public function getQuestion() {
return t('Delete %cid?', array('%cid' => $this->cid));
}
public function getCancelUrl() {
return new Url('mydata.display_table_controller_display');
}
public function getDescription() {
return t('If you want to delete click Delete!');
}

public function getConfirmText() {
return t('Delete ');
}

public function getCancelText() {
return t('Cancel');
}

public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
$this->id = $cid;
return parent::buildForm($form, $form_state);
}

public function validateForm(array &$form, FormStateInterface $form_state) {
parent::validateForm($form, $form_state);
}

public function submitForm(array &$form, FormStateInterface $form_state) {
 $query = \Drupal::database();
 $query->delete('mydata')
             ->condition('id',$this->id)
            ->execute();
       drupal_set_message("succesfully deleted");
      $form_state->setRedirect('mydata.display_table_controller_display');
}
}
