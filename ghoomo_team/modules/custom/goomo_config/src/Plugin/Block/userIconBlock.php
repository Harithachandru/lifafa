<?php

namespace Drupal\goomo_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'SurveyBlock' block.
 *
 * @Block(
 *  id = "user_icon_block",
 *  admin_label = @Translation("user Icon block"),
 * )
 */
class userIconBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */


    public function build() {
        global $base_url;
        $request = \Drupal::request();
        $current_path = $request->getPathInfo();
        $path_args = explode('/', $current_path);
        $store = $path_args[1];

    if($store=='store'){
        $icon = $store;
    }
    else{
        $icon='';
    }
   
    $build = [];
    $build['#theme'] = 'user_icon_block';
    $build['user_icon_block']['#markup'] = 'Implement userIconBlock.';
    $build['#cache'] = ['max-age' => 0];
    $build['#usericon']= $icon;
    $build['#available_point']= $points;
    return $build;
  }
}
