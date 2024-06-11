<?php

namespace Drupal\workperx_config\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class Controller extends ControllerBase {

  public function getUserDetails(Request $request) {
    
    $data = $request->request->all();
    // Use the $data array to create a new coding entity
    // ...

    


    return new JsonResponse($data);
  }

  public function post(Request $request) {
    

    // Get the user data from the request body.
    $user_data = json_decode(\Drupal::request()->getContent());

    // Do something with the user data, such as save it to a custom entity or display it on the page.
    // For example:
    $output = '';
    foreach ($user_data as $key => $value) {
      $output .= $key . ': ' . $value . '<br>';
    }
    return [
      '#markup' => $this->t('User data received from domain1.com:<br>@data', ['@data' => $output]),
    ];

  }

  public function receiveUserData() {
    // Get the user data from the request body.
    echo "hii";

  }



}
