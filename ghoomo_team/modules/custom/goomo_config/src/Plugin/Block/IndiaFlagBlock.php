<?php

namespace Drupal\goomo_config\Plugin\Block;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SurveyBlock' block.
 *
 * @Block(
 *  id = "india_flag_block",
 *  admin_label = @Translation("India Flag block"),
 * )
 */
class IndiaFlagBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {


     $request = \Drupal::request();
        $current_path = $request->getPathInfo();
        $path_args = explode('/', $current_path);
        $first_argument = $path_args[1];
    $country_code = (!empty($first_argument) && $first_argument=='uk')?'uk':'in';
    $build = [];
    $build['#theme'] = 'india_flag_block';
    $build['india_flag_block']['#markup'] = 'Implement country switch.';
    $build['#country_code'] = $country_code;
    $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
