<?php
namespace Drupal\mydata\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

class DisplayTableController extends ControllerBase {
     public function getContent() {

    $build = [
      'description' => [
        '#theme' => 'mydata_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  public function display() {

    $header_table = array(
     'id'=>    t('SrNo'),
      'name' => t('Name'),
        'mobilenumber' => t('MobileNumber'),
        'dob' => t('Date Of Birth'),
        'age' => t('Age'),
        'joining_date' => t('Joining date'),
        'gender' => t('Gender'),
        'opt' => t('operations'),
        'opt1' => t('operations'),
    );

    $query = \Drupal::database()->select('mydata', 'm');
        $query->fields('m', ['id','name','mobilenumber','email','dob','age','joining_date','gender','website']);
      $results = $query->execute()->fetchAll();
        $rows=array();
    foreach($results as $data){
        $delete = Url::fromUserInput('/mydata/form/delete/'.$data->id);
        $edit   = Url::fromUserInput('/mydata/form/mydata?num='.$data->id);
             $rows[] = array(
                'id' =>$data->id,
                'name' => $data->name,
                'mobilenumber' => $data->mobilenumber,
                'dob' => $data->dob,
                'age' => $data->age,
                'joining_date' => $data->joining_date,
                'gender' => $data->gender,
                 \Drupal::l('Delete', $delete),
                 \Drupal::l('Edit', $edit),
            );
}

    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
        return $form;
}
}
