<?php
namespace Drupal\mydata\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MydataForm extends FormBase {

  public function getFormId() {
    return 'mydata_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
      //$form['#attached']['js'][] = drupal_get_path('module', 'mydata') . '/js/hi.js';
    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('mydata', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();
    }

    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t(' Name:'),
      '#required' => TRUE,
      '#placeholder' => 'Enter the name',
      '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      );
    $form['mobile_number'] = array(
      '#type' => 'textfield',
      '#title' => t('Mobile Number:'),
      '#placeholder' => '123456789',
      '#default_value' => (isset($record['mobilenumber']) && $_GET['num']) ? $record['mobilenumber']:'',
      );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email Address:'),
      '#placeholder' => 'abcde@gmail.com',
      '#required' => TRUE,
      '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
      );
      $form['dob'] = array(
        '#type' => 'textfield',
        '#title' => t('Date Of Birth'),
        '#placeholder' => 'Y-m-d',
        '#default_value' => (isset($record['dob']) && $_GET['num']) ? $record['dob']:'',
        );

    $form['candidate_age'] = array (
      '#type' => 'textfield',
      '#title' => t('Age'),
      '#placeholder' => 'Enter the age',
      '#default_value' => (isset($record['age']) && $_GET['num']) ? $record['age']:'',

       );

       $form['joining_date'] = array (
         '#type' => 'textfield',
         '#title' => t('Joining date'),
         '#placeholder' => 'Y-m-d',
         '#default_value' => (isset($record['joining_date']) && $_GET['num']) ? $record['joining_date']:'',
          );


    $form['candidate_gender'] = array (
      '#type' => 'select',
      '#title' => ('Gender'),
      '#options' => array(
        'Female' => t('Female'),
        'male' => t('Male'),
        '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
        ),
      );
  $form['web_site'] = array (
      '#type' => 'textfield',
      '#title' => t('web site'),
      '#default_value' => (isset($record['website']) && $_GET['num']) ? $record['website']:'',
       );
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'save',

    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('candidate_name');
          if(preg_match('/[^A-Za-z]/', $name)) {
             $form_state->setErrorByName('candidate_name', $this->t('your name must in characters without space'));
          }
        if (!intval($form_state->getValue('candidate_age'))) {
             $form_state->setErrorByName('candidate_age', $this->t('Age needs to be a number'));
            }
      $joining_date = $form_state->getValue('joining_date');
      $dob = $form_state->getValue('dob');
    /* echo  '<br>'.$str = strtotime($form_state->getValue('joining_date')); //echo $form_state->getValue('joining');
      echo '<br>'.date('Y-m-d',$str);
die;
        //echo $joining;
        die('===');*/
        if($joining_date <= $dob){
           $form_state->setErrorByName('joining_date', $this->t('Joining date must be grater than Date of birth'));
          //echo "Joining date must be grater than Date of birth";
        }
        // $dob = $form_state->getValue('dob');
        // $age=$form_state->getValue($dob->age);
        //
        // if(!empty($dob)){
        //
        //     echo $form_state = (date('Y') - date('Y',strtotime($dob)));die;
        //    }

          parent::validateForm($form, $form_state);
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field=$form_state->getValues();
    $name=$field['candidate_name'];
    $number=$field['mobile_number'];
    $email=$field['candidate_mail'];
    $dob=$field['dob'];
    $age=$field['candidate_age'];
    $joining_date=$field['joining_date'];
    $gender=$field['candidate_gender'];
    $website=$field['web_site'];
    if (isset($_GET['num'])) {
          $field  = array(
              'name'   => $name,
              'mobilenumber' =>  $number,
              'email' =>  $email,
              'dob' => $dob,
              'age' => $age,
              'joining_date' => $joining_date,
              'gender' => $gender,
              'website' => $website,
          );
          $query = \Drupal::database();
          $query->update('mydata')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          $form_state->setRedirect('mydata.display_table_controller_display');
      }
       else
       {
           $field  = array(
              'name'   =>  $name,
              'mobilenumber' =>  $number,
              'email' =>  $email,
              'dob' => $dob,
              'age' => $age,
              'joining_date' => $joining_date,
              'gender' => $gender,
              'website' => $website,
          );
           $query = \Drupal::database();
           $query ->insert('mydata')
               ->fields($field)
               ->execute();
           drupal_set_message("succesfully saved");
           $response = new RedirectResponse("/sri/web/mydata/hello/table");
           $response->send();
       }
     }
}
