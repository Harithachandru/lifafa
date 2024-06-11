<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ComingsoonLogoBlock' block.
 *
 * @Block(
 *  id = "comingsoon_logo_block",
 *  admin_label = @Translation("Comingsoon Logo block"),
 * )
 */
class ComingsoonLogoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {




    $build = [];
    $build['#theme'] = 'comingsoon_logo_block';
    $build['comingsoon_logo_block']['#markup'] = 'Implement ComingsoonLogoBlock.';
     $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
