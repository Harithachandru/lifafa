<?php

namespace Drupal\fundle_store\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'BannerBlock' block.
 *
 * @Block(
 *  id = "Home_banner_block",
 *  admin_label = @Translation("Home Banner Slider block"),
 * )
 */
class HomeBannerBlock extends BlockBase {

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
    $build['#theme'] = 'homepage_banner_slider';
    $build['default_block']['#markup'] = 'Implement DefaultBlock.';
    $build['#content'] = $data;
    $build['#markup'] = 'Implement DefaultBlock.';
    return $build;
  }
  
  public function getBannerData($mallId=''){
      
      
      $request = \Drupal::request();
        $current_path = $request->getPathInfo();
        $path_args = explode('/', $current_path);
        $first_argument = $path_args[4];
       if(!empty($first_argument) && $first_argument!='home'){            
            $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')
            ->loadByProperties(['name' => $first_argument, 'vid' => 'category']);
            $term = reset($term);
            $term_id = $term->id();
       }
      
        $bannerData=[];                
        $current_time = \Drupal::time()->getCurrentTime();    
        $currDate = date('Y-m-d', $current_time); 
         
        $storage = \Drupal::entityTypeManager()
        ->getStorage('node');
        $qry = $storage->getQuery()
        ->condition('type','top_deal')
        ->condition('field_isbanner',1)
        ->condition('field_mall_id',$mallId)
        ->condition('status', 1)
        ->condition('field_banner_start_date', $currDate,'<=')
        ->condition('field_banner_end_date', $currDate, '>=' )     
        ->execute();        
        $nodes_deal = $storage->loadMultiple( $qry );
        
        if(!empty($nodes_deal)){
            foreach ($nodes_deal as $deals){               
                $deals_nid = $deals->nid->value;                
                if(!empty($term_id) && $term_id==$deals->field_category->target_id){
                    $deal_banner_id =$deals->field_promotion_banner->target_id;
                    if(!empty($deal_banner_id)){                 
                          $deal_banner_url = getFileUrl($deal_banner_id);
                          $bannerData[$deals_nid]['banner_heading'] = $deals->field_header->value;
                          $bannerData[$deals_nid]['bannerUrl'] = $deal_banner_url;                          
                    }
                }
                if(!empty($deals_nid)){
                    $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$deals_nid);
                    $bannerData[$deals_nid]['nodeLaliasUrl'] = $alias;                
                }
                
                if(empty($term_id) && !empty($first_argument) && $first_argument=='home'){
                    $deal_banner_id =$deals->field_promotion_banner->target_id;
                    if(!empty($deal_banner_id)){                 
                          $deal_banner_url = getFileUrl($deal_banner_id);
                          $bannerData[$deals_nid]['banner_heading'] = $deals->field_header->value;
                          $bannerData[$deals_nid]['bannerUrl'] = $deal_banner_url;
                    }
                    if(!empty($deals_nid)){
                    $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/'.$deals_nid);
                    $bannerData[$deals_nid]['nodeLaliasUrl'] = $alias;                
                }
                }
            }
        }

        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'mall_banner', 'field_mall_id' => $mallId,'status'=>1]);
        if(!empty($nodes)){
          foreach ($nodes as $node){
            $arr = [];
            $nid = $node->nid->value;

        //    dump($node->field_banner_heading->value);
            $displayValues = $node->field_banner_display_page->getValue();
            foreach($displayValues as $vals){
                $arr[] = $vals['target_id'];                  
            }

            if(!empty($term_id) && in_array($term_id, $arr)){
                 $banner_id = $node->field_banner->target_id;
                  if (!empty($banner_id)) {
                      $node_banner_url = getFileUrl($banner_id);
                      $bannerData[$nid]['banner_heading'] = $node->field_banner_heading->value;
                      $bannerData[$nid]['bannerUrl'] = $node_banner_url;
                  }                 
            }
            
            if($node->field_ishomepage->value==1 && empty($term_id) && !empty($first_argument) && $first_argument=='home'){
               $banner_id = $node->field_banner->target_id;
                  if (!empty($banner_id)) {
                      $node_banner_url = getFileUrl($banner_id); 
                      $bannerData[$nid]['banner_heading'] = $node->field_banner_heading->value;
                      $bannerData[$nid]['bannerUrl'] = $node_banner_url;
                  }  
            }
            
          }
        }
        return $bannerData;
    }

}
