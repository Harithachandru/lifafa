<?php

namespace Drupal\workperx_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class GcmApi.
 */
class WorkperxConfig extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'workperx_config.workperx_url',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'workperx_urls';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workperx_config.workperx_url');
    
    $form['signin_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Sign In Url'),
      '#default_value' => $config->get('signin_url'),
    ];

    $form['signup_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Sign Up Url'),
      '#default_value' => $config->get('signup_url'),
    ];

    $form['storeId'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Workperx Store Id'),
      '#default_value' => $config->get('storeId'),
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

    $form['store_myaccount_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Store Myaccount URL'),
      '#default_value' => $config->get('store_myaccount_url'),
    ];

    $form['store_home_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Store Home URL'),
      '#default_value' => $config->get('store_home_url'),
    ];

    $form['logout_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Logout URL'),
      '#default_value' => $config->get('logout_url'),
    ];

    $form['lifafa_contact_us_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Lifafa Contact Us URL'),
      '#default_value' => $config->get('lifafa_contact_us_url'),
    ];
    $form['header_block_url'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Header Block URL'),
      '#default_value' => $config->get('header_block_url'),
    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('workperx_config.workperx_url')            
      ->set('signin_url', $form_state->getValue('signin_url'))
      ->set('signup_url', $form_state->getValue('signup_url'))
      ->set('storeId', $form_state->getValue('storeId'))
      ->set('lauth_url', $form_state->getValue('lauth_url'))
      ->set('client_id', $form_state->getValue('client_id'))
      ->set('redirect_uri', $form_state->getValue('redirect_uri'))
      ->set('get_token_url', $form_state->getValue('get_token_url'))
      ->set('store_myaccount_url', $form_state->getValue('store_myaccount_url'))
      ->set('store_home_url', $form_state->getValue('store_home_url'))
      ->set('logout_url', $form_state->getValue('logout_url'))
      ->set('lifafa_contact_us_url', $form_state->getValue('lifafa_contact_us_url'))
      ->set('header_block_url', $form_state->getValue('header_block_url'))
      ->save();
  }

}
