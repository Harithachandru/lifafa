<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SurveyBlock' block.
 *
 * @Block(
 *  id = "survey_block",
 *  admin_label = @Translation("Survey block"),
 * )
 */
class SurveyBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'survey_block';
     $build['survey_block']['#markup'] = 'Implement SurveyBlock.';

    return $build;
  }

}
