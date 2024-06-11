<?php

namespace Drupal\lifafa_user\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LifafaConfig.
 */
class LifafaUser extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'lifafa_user.lifafauser',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lifafa_admin_user';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('lifafa_user.lifafauser');
    
    
    
  
    $form['api_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('User Api Url'),
      '#default_value' => $config->get('api_url'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('lifafa_user.lifafauser')            
      ->set('api_url', $form_state->getValue('api_url'))
     
      ->save();
  }

}
