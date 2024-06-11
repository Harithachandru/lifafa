<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'TopdealsLogoBlock' block.
 *
 * @Block(
 *  id = "topdeals_logo_block",
 *  admin_label = @Translation("Topdeals Logo block"),
 * )
 */
class TopdealsLogoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {




    $build = [];
    $build['#theme'] = 'topdeals_logo_block';
    $build['topdeals_logo_block']['#markup'] = 'Implement TopdealsLogoBlock.';
     $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
