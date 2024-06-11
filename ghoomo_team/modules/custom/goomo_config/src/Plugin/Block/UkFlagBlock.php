<?php

namespace Drupal\goomo_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SurveyBlock' block.
 *
 * @Block(
 *  id = "uk_flag_block",
 *  admin_label = @Translation("Uk Flag block"),
 * )
 */
class UkFlagBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
      
      
      
      
    $build = [];
    $build['#theme'] = 'uk_flag_block';
    
    $build['uk_flag_block']['#markup'] = 'Implement LoginButtonBlock.';
     $build['#cache'] = ['max-age' => 0];  

    return $build;
  }

}
