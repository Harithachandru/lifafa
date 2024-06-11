<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PerksSliderBlock' block.
 *
 * @Block(
 *  id = "perks_slider_block",
 *  admin_label = @Translation("Perks Slider block"),
 * )
 */
class PerksSliderBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'perks_slider_block';
    $build['perks_slider_block']['#markup'] = 'Implement PerksSliderBlock.';
    return $build;
  }

}
