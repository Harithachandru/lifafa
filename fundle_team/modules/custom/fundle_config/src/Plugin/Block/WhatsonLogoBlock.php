<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'WhatsonLogoBlock' block.
 *
 * @Block(
 *  id = "whatson_logo_block",
 *  admin_label = @Translation("Whatson Logo block"),
 * )
 */
class WhatsonLogoBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {




    $build = [];
    $build['#theme'] = 'whatson_logo_block';
    $build['whatson_logo_block']['#markup'] = 'Implement WhatsonLogoBlock.';
     $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
