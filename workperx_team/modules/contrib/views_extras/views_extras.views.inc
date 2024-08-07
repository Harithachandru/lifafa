<?php

/**
 * Implements hook_views_data().
 */
function views_extras_views_data() {
  $data['views']['extra_result'] = [
    'title' => t('Extra Result summary'),
    'help' => t('Shows result summary, for example the items per page.'),
    'area' => [
      'id' => 'extra_result',
    ],
  ];

  return $data;
}
