<?php
namespace Drupal\mydata\Plugin\Block;
use Drupal\Core\Block\BlockBase;

class MydataBlock extends BlockBase {

  public function build() {
    
    $form = \Drupal::formBuilder()->getForm('Drupal\mydata\Form\MydataForm');
    return $form;
  }
}
