<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'ViewparkingChargesBlock' block.
 *
 * @Block(
 *  id = "viewparking_charges_block",
 *  admin_label = @Translation("Viewparking Charges Block"),
 * )
 */
class ViewparkingChargesBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $request = \Drupal::request();
    $current_path = $request->getPathInfo();
    $path_args = explode('/', $current_path);
    $mall = $path_args[3];
    
    $park='';
    if(!empty($mall)){
     $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['status'=>1,'field_mall_id'=>$mall,'type'=>'mall']);    
     if (!empty($nodes) && $node = reset($nodes)) { 
         $node->id();         
        $park=  $node->field_park_url->value; 
     }
    }
     
     
    $build = [];
    $build['#theme'] = 'viewparking_charges_block';
    $build['viewparking_charges_block']['#markup'] = 'Implement ViewparkingChargesBlock.';
    $build['#park_type'] = $park;
    return $build;
      }

   }
