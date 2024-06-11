<?php

namespace Drupal\torchlight_tfa\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Url;

/**
 * TFA user login form.
 */
class VerifyOtp extends ControllerBase {
    /**
   * {@inheritdoc}
   */ 
  public function verify() {
    $response = new AjaxResponse();    
    $response->addCommand(new CloseModalDialogCommand());
    return $response;
  }
}