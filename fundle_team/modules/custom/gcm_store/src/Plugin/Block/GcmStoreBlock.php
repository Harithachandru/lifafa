<?php

namespace Drupal\gcm_store\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'GcmStoreBlock' block.
 *
 * @Block(
 *  id = "gcm_store_block",
 *  admin_label = @Translation("GCM Store block"),
 * )
 */
class GcmStoreBlock extends BlockBase {

    /**
     * 
     * @param array $variables
     */
//    public function gcm_store_preprocess_html(&$variables) {
//            $variables['page']['#attached']['library'][] = 'modules\Fussion_Modules\block_header';
//    }    
    
    
  /**
   * {@inheritdoc}
   */
  public function build() {
      
     global $base_url;
    $request = \Drupal::request();
    $current_path = $request->getPathInfo();
    $path_args = explode('/', $current_path);
    $storeId = strtolower($path_args[2]); // lower case for the gcm url generation
    $mall = $path_args[3];
            
    
//    if($mall!='mall'){
//        $storeID = $path_args[1];
//    }else{
//        $storeID = $path_args[3];
//    }
//     
//     
    $store_url = \Drupal::config('gcm_store.gcmconfig')->get('store_url');

    $query = \Drupal::entityQuery('node')
    ->condition('status', 1) //published or not
    ->condition('type', 'discount_vouchers'); //content type
    $nids = $query->execute();
    $node_storage = \Drupal::entityTypeManager()->getStorage('node');
    $nodes = $node_storage->loadMultiple($nids);

//   dump($nodes);

    $data = [];
    $currentStore = $mall;
    //$currentStore =  getStoreIdFromSession();
 

//        if (\Drupal::currentUser()->isAnonymous()) {
//            $node = \Drupal::routeMatch()->getParameter('node');
//            $currentStore = $node->field_store_id->value;
//            $gcm = $node->field_store_type->value;
//            $viewall = $node->field_gcm_viewall->value;
//        } else {
//
//            $nodes2 = \Drupal::entityTypeManager()
//                    ->getStorage('node')
//                    ->loadByProperties(['field_store_id' => $storeID, 'status' => 1]);
//
//            if (empty($nodes2)) {
//                $nodes2 = \Drupal::entityTypeManager()
//                        ->getStorage('node')
//                        ->loadByProperties(['field_store_id' => $currentStore, 'status' => 1]);
//            }
//
//            if (!empty($nodes2) && $node2 = reset($nodes2)) {
//                $gcm = $node2->field_store_type->value;
//                $viewall = $node2->field_gcm_viewall->value;
//            }
//        }
        

        foreach($nodes as $node){

            $category = $node->field_category->target_id;
            $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($category);
            $categoryTitle = $term->name->value;
            //$categoryUrl = $term->field_store_category_url->value;
           $nid = $node->id();
           $store_disocunt_type = $node->field_discount_type_detail->getValue();            
            if (!empty($store_disocunt_type)) {
                             
               // $data[$category]['data'][$nid]['field_store']='';
                foreach ($store_disocunt_type as $element_block) {
                    
                    $pblock = \Drupal\paragraphs\Entity\Paragraph::load($element_block['target_id']);                    
                    $store_nid = $pblock->field_mall->target_id;
                    $brandNode = Node::load($store_nid);
                    //dump($brandNode);
                    if($mall==$brandNode->field_mall_id->value){
                      //  echo $currentStore."==".$brandNode->field_store_id->value;
                       // dump($pblock);
                        $discount = $pblock->field_discount->value;
                        $discountType = $pblock->field_discount_type->value;                   
                        $special_offer = $pblock->field_special_offer->value; 
                        $data[$category]['data'][$nid]['field_discount'] = $discount;
                        $data[$category]['data'][$nid]['field_special_offer'] = $special_offer;
                        $data[$category]['data'][$nid]['field_discount_type'] = $discountType;
                        $store_node = \Drupal\node\Entity\Node::load($store_nid);
                      //  if($currentStore==$store_node->field_store_id->value){
                        $data[$category]['data'][$nid]['field_store'] = $store_node->field_store_id->value;
                        //$data[$category]['data'][$nid]['field_discount_type'] = $pblock->field_discount_type->value;
                            if(!empty($pblock->field_discount_type->value)){
                                $discountType = $pblock->field_discount_type->value;
                                //break;
                            }
                        //}
                    }else{
                        continue;
                    }
                }
                            
            if(!empty($data[$category]['data'][$nid]['field_store'])){    
                $data[$category]['category_title'] = $categoryTitle;
                $data[$category]['category_url'] = $categoryUrl;
                $data[$category]['data'][$nid]['title'] = trim($node->title->value);
                $data[$category]['data'][$nid]['body'] = $node->body->value;
                //$data[$category]['data'][$nid]['field_discount'] = $node->field_discount->value;
                $data[$category]['data'][$nid]['field_external_url'] = $node->field_external_url->value;
                $file = \Drupal\file\Entity\File::load($node->field_image->target_id);
                $path = $file->getFileUri();
                $url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
				!empty(getenv('APP_ENV')) ? true : false
			     ])->toString();
                $data[$category]['data'][$nid]['field_image'] =   $url;  
            }
            }else{
                continue;
            }
}
//        $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);        
//        $title = $term->name->value;
//        $sub_title = $term->field_sub_title->value;
//        $category_image_id = $term->field_category_image->target_id;
    $build = [];
    $build['#theme'] = 'gcm_store_block';
    $build['default_block']['#markup'] = 'Implement DefaultBlock.';
    $build['#content'] = $data;
    $build['#gcm_type'] = $gcm;
    $build['#gcm_viewall'] = $store_url.$storeId.'/'.$currentStore.'-02/gcm/';
    $build['#discount_url'] = $discountType;
    $build['#store_landing_url'] = $store_url.$storeId.'/'.$currentStore;
    $build['#current_store_id'] = $currentStore;    
    $build['#markup'] = 'Implement DefaultBlock.';
    return $build;
  }
}
