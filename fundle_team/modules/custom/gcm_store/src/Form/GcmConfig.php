<?php

namespace Drupal\gcm_store\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LifafaConfig.
 */
class GcmConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'gcm_store.gcmconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'gcm_admin_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('gcm_store.gcmconfig');
    
    $form['store_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Store URL'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('store_url'),
    ];
    
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#maxlength' => 64,
      '#size' => 64,
      '#default_value' => $config->get('name'),
    ];
    $form['state'] = [
      '#type' => 'select',
      '#title' => $this->t('State'),
      '#options' => ['test' => $this->t('test')],
      '#size' => 5,
      '#default_value' => $config->get('state'),
    ];
    $form['office_address'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Office Address'),
      '#default_value' => $config->get('office_address'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('gcm_store.gcmconfig')            
      ->set('name', $form_state->getValue('name'))
      ->set('state', $form_state->getValue('state'))
      ->set('store_url', $form_state->getValue('store_url'))      
      ->set('office_address', $form_state->getValue('office_address'))
      ->save();
  }

}
