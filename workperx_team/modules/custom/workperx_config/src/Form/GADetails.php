<?php

namespace Drupal\workperx_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class GADetails.
 */
class GADetails extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'workperx_config.ga_details',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ga_details';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workperx_config.ga_details');
    
    $form['ga_measurement_id'] = [
        '#type' => 'textarea',
        '#title' => $this->t('GA Measurement Id'),
        '#default_value' => $config->get('ga_measurement_id'),
      ];

   
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('workperx_config.ga_details')            
      
      ->set('ga_measurement_id', $form_state->getValue('ga_measurement_id'))  
      ->save();
  }

}
