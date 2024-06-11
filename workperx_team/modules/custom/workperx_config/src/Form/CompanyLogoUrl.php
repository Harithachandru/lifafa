<?php

namespace Drupal\workperx_config\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CompanyLogoUrl.
 */
class CompanyLogoUrl extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'workperx_config.company_logo_url',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'company_logo_url';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('workperx_config.company_logo_url');
    
    $form['company_logo_url'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Company Logo Url'),
        '#default_value' => $config->get('company_logo_url'),
      ];

   
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('workperx_config.company_logo_url')            
      
      ->set('company_logo_url', $form_state->getValue('company_logo_url'))  
      ->save();
  }

}
