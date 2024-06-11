<?php

namespace Drupal\goomo_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class LifafaConfig.
 */
class GoomoUser extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'goomo_user.goomouser',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'goomo_admin_user';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
  //  $form_state->setCached (FALSE);
    $config = $this->config('goomo_user.goomouser');
    
   // $form_state->setCached (FALSE);
    
  
    $form['api_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('User Api Url'),
      '#default_value' => $config->get('api_url'),
      '#cache' => ['max-age' => 0,],
  
    ];
    $form['lauth_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('lAuth URL'),
      '#default_value' => $config->get('lauth_url'),
    ];

    $form['client_id'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Client Id'),
      '#default_value' => $config->get('client_id'),
    ];

    $form['redirect_uri'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Redirect URL'),
      '#default_value' => $config->get('redirect_uri'),
    ];
    $form['get_token_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Get User Token URL'),
      '#default_value' => $config->get('get_token_url'),
    ];
    $form['logout_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Logout URL'),
      '#default_value' => $config->get('logout_url'),
    ];


    //$form['#cache']['max-age'] = 0;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('goomo_user.goomouser')            
      ->set('api_url', $form_state->getValue('api_url'))
      ->set('lauth_url', $form_state->getValue('lauth_url'))
      ->set('client_id', $form_state->getValue('client_id'))
      ->set('redirect_uri', $form_state->getValue('redirect_uri'))
      ->set('get_token_url', $form_state->getValue('get_token_url'))
      ->set('logout_url', $form_state->getValue('logout_url'))
      ->save();
  }

}
