<?php

namespace Drupal\lifafa_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LifafaConfig.
 */
class LifafaConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'lifafa_config.lifafaconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'lifafa_admin_config';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('lifafa_config.lifafaconfig');
    
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

    $this->config('lifafa_config.lifafaconfig')            
      ->set('name', $form_state->getValue('name'))
      ->set('state', $form_state->getValue('state'))
      ->set('store_url', $form_state->getValue('store_url'))      
      ->set('office_address', $form_state->getValue('office_address'))
      ->save();
  }

}
