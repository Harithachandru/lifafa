<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'LaunchofferBlock' block.
 *
 * @Block(
 *  id = "launchoffer_block",
 *  admin_label = @Translation("Launchoffer block"),
 * )
 */
class LaunchofferBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {




    $build = [];
    $build['#theme'] = 'launchoffer_block';
    $build['launchoffer_block']['#markup'] = 'Implement LaunchofferBlock.';
     $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
