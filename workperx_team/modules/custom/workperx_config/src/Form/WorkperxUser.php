<?php

namespace Drupal\workperx_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class WorkperxUser.
 */
class WorkperxUser extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'workperx_config.workperx_user',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workperx_user';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workperx_config.workperx_user');
    
    $form['workperx_user'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Workperx User Url'),
        '#default_value' => $config->get('workperx_user'),
      ];

   
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('workperx_config.workperx_user')            
      
      ->set('workperx_user', $form_state->getValue('workperx_user'))  
      ->save();
  }

}
