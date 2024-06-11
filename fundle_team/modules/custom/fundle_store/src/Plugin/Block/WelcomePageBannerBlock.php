<?php

namespace Drupal\fundle_store\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'WelcomePageBannerBlock' block.
 *
 * @Block(
 *  id = "welcome_page_banner_block",
 *  admin_label = @Translation("Welcome Page Banner block"),
 * )
 */
class WelcomePageBannerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
      
      
      
    $request = \Drupal::request();
    $current_path = $request->getPathInfo();
    $path_args = explode('/', $current_path);      
    $first_argument = $path_args[3];
    $data = $this->getBannerData($first_argument);

    $build = [];
    $build['#theme'] = 'welcome_page_banner';
    $build['default_block']['#markup'] = 'Implement DefaultBlock.';
    $build['#content'] = $data;
    $build['#markup'] = 'Implement DefaultBlock.';
    return $build;
  }
  
  public function getBannerData($mallId=''){
      
        $bannerData=[];                
        $current_time = \Drupal::time()->getCurrentTime();    
        $currDate = date('Y-m-d', $current_time); 
         
        $storage = \Drupal::entityTypeManager()
        ->getStorage('node');
        $qry = $storage->getQuery()
        ->condition('type','welcome_banners')
//        ->condition('field_isbanner',1)
//        ->condition('field_mall_id',$mallId)
        ->condition('status', 1)
//        ->condition('field_banner_start_date', $currDate,'<=')
//        ->condition('field_banner_end_date', $currDate, '>=' )     
        ->execute();        
        $nodes_deal = $storage->loadMultiple( $qry );       
        if(!empty($nodes_deal)){
            foreach ($nodes_deal as $deals){
                
               $nid = $deals->nid->value;
               $deal_banner_id =$deals->field_image->target_id;
               $banner_heading = $deals->field_banner_heading->value;               
                if(!empty($deal_banner_id)){                 
                      $deal_banner_url = getFileUrl($deal_banner_id);
                      $bannerData[$nid]['bannerUrl'] = $deal_banner_url;
                }
                $bannerData[$nid]['banner_heading'] = $banner_heading;
            }
        }
         
        
        return $bannerData;
    }
  

}
