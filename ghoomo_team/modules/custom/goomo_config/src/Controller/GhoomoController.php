<?php

namespace Drupal\goomo_config\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Routing\TrustedRedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GhoomoController extends ControllerBase
{

  public function logout()
  {
    \Drupal::service('page_cache_kill_switch')->trigger();

    global $base_url;
    $countryCode = '';
    $request = \Drupal::request();
    $cookies = $request->cookies;
    $countryCode = $cookies->get('countrycode');

    // The URL to which you want to redirect for logout.
    $url = \Drupal::config('goomo_user.goomouser')->get('logout_url');
    $logout_url = str_replace('#countryCode#', $countryCode, $url);
    $userdata = getauthToken();
    $storeId = $userdata['storeId'];

    //\Drupal::logger('goomo_config')->info($storeId);
    if (!empty($storeId)) {
      $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(
        ['type' => 'customer_store', 'field_store_id' => $storeId, 'status' => 1]
      );
      if ($node = reset($nodes)) {
        $external_logout_url = $node->field_external_logout_url->value;
      }
    }
    $logoutUrl = '';
    $logoutUrl = $logout_url;
    $response = new TrustedRedirectResponse($logoutUrl);
    // Clear the session data.
    \Drupal::service('session_manager')->destroy();
    return $response;
  }
  public function sendNotificationToRN(Request $request)
  {

    return [
      '#theme' => 'sendNotificaionToRn'
    ];
  }
}
