<?php

namespace Drupal\fundle_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DiscoverOfferBlock' block.
 *
 * @Block(
 *  id = "discover_offer_block",
 *  admin_label = @Translation("Discover Offer block"),
 * )
 */
class DiscoverOfferBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {


$form = \Drupal::formBuilder()->getForm('\Drupal\fundle_config\Form\DiscoverOffer');
return $form;
    $build = [];
    //$build['#theme'] = 'whatson_logo_block';
    $build['#form'] = $form;
    $build['whatson_logo_block']['#markup'] = 'Implement WhatsonLogoBlock.';
     $build['#cache'] = ['max-age' => 0];

    return $build;
  }

}
