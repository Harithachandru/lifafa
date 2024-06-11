<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\user\PrivateTempStoreFactory;
use Drupal\lifafa_store\Controller\LifafaStoreController;

/**
 * Provides a 'HeaderBlock' block.
 *
 * @Block(
 *  id = "header_block",
 *  admin_label = @Translation("Header block"),
 * )
 */
class HeaderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
      
    
    $storeId = '';
    $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');    
    $store_url = \Drupal::config('lifafa_config.lifafaconfig')->get('store_url');
    $sid = getStoreIdFromSession();
    $storeData = LifafaStoreController::getStoreData($sid);    
          //  dump($storeData);die;
//    if(empty($storeData)){
//       // echo "Do redirect 404";
//         $response = new RedirectResponse('system.404');
//            $response->send();
//            return new Response();
//    }  
    
    
    if (\Drupal::currentUser()->isAnonymous()) {
            $response = new RedirectResponse('/user/login');
            $response->send();
            return new Response();
    }    
    
   
    $build = [];
    $build['#theme'] = 'header_block';
    $build['header_block']['#markup'] = 'Implement HeaderBlock.';
    $build['#storedata'] = $storeData;
    $build['#cache'] = ['max-age' => 0];
    return $build;
  }

}