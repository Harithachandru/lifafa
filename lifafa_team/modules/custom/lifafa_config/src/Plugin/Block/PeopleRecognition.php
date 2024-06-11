<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'PeopleRecognition' block.
 *
 * @Block(
 *  id = "people_recognition",
 *  admin_label = @Translation("People recognition"),
 * )
 */
class PeopleRecognition extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['#theme'] = 'people_recognition';
     $build['people_recognition']['#markup'] = 'Implement PeopleRecognition.';

    return $build;
  }

}
