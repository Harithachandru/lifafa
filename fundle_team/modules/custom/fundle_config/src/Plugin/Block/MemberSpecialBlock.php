<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
 use Drupal\node\Entity\Node;
/**
 * Provides a 'MemberSpecialBlock' block.
 *
 * @Block(
 *  id = "member_special_block",
 *  admin_label = @Translation("Member Special Block"),
 * )
 */
class MemberSpecialBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    global $base_url;
    $request = \Drupal::request();
    $current_path = $request->getPathInfo();
    $path_args = explode('/', $current_path);
    $mall = $path_args[3];
    
    $member_special ='';
    if(!empty($mall)){
     $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['status'=>1,'field_mall_id'=>$mall,'type'=>'mall']);    
     if (!empty($nodes) && $node = reset($nodes)) { 
         $node->id();         
        $member_special=  $node->body->value; 
     }
    }
     
     
    $build = [];
    $build['#theme'] = 'member_special_block';
    $build['member_special_block']['#markup'] = 'Implement MemberSpecialBlock.';
    $build['#member_special'] = $member_special;
    return $build;
      }

   }

