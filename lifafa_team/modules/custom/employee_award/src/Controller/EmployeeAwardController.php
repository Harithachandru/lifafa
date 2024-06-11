<?php
namespace Drupal\employee_award\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * Provides route responses for the Example module.
 */
class EmployeeAwardController extends ControllerBase {

  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
  public function sendgiftcardpage() {

    $store_url = \Drupal::config('lifafa_config.lifafaconfig')->get('store_url');
     $data = $store_url;
     if(isset($_COOKIE['storeid'])){
      $store_id = $_COOKIE['storeid'];
      
     }

     if (\Drupal::currentUser()->isAnonymous()) {
      $node = \Drupal::routeMatch()->getParameter('node');
      $currentStore =  $node->field_store_id->value;
      $gcm =  $node->field_store_type->value;
  
     }  
 
    return [
      '#theme' => 'send_giftcard',
      '#store_baseurl' => $data,
      '#current_store_id' => $store_id
    
    ];
   
  }

}