<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SurveyBlock' block.
 *
 * @Block(
 *  id = "login_button_block",
 *  admin_label = @Translation("Login Button block"),
 * )
 */
class LoginButtonBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
      
      if ($node = \Drupal::request()->attributes->get('node')) {      
      if($node->getType()=='customer_store'){  
       $field_store_id = $node->field_store_id->value;   
      }
      }
      
      
    $build = [];
    $build['#theme'] = 'login_button_block';
    $build['#content'] = $field_store_id;
    $build['survey_block']['#markup'] = 'Implement LoginButtonBlock.';
     $build['#cache'] = ['max-age' => 0];  

    return $build;
  }

}
