<?php

namespace Drupal\torchlight_tfa\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Url;

use Drupal\Core\Form\FormBuilderInterface;

/**
 * TFA user login form.
 */
class OtpVerification extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
      return 'torchlight_tfa_otp_verification';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $data = array()) {
	$session = \Drupal::service('session');
    $otp = $session->get('tfa_otp');
        //echo "OTP IS: ".$session->get('tfa_otp');

    $form['#prefix'] = '<div class="container pt-50" id="otp_verification_form">';
    $form['#suffix'] = '</div>';
    $form['html'] = [
      '#markup' => '<div class="align-center">
      <h3>Enter OTP</h3>
      <p>This is a secure site. To protect you, a code has been sent to your email address.</p>
      <p>Kindly copy the code and enter it below.</p>
      </div>',
    ];
/*    $form['status_messages'] = [
      '#type' => 'status_messages',
      '#weight' => -10,
    ]; */       
    $form['otp'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Otp'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['otp-field']],
      '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => t('One Time Password'),
      '#size' => 6,
      '#maxlength' => 6,
    ];
    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Verify'),
      '#attributes' => ['class' => ['btn btn-success']],   
/*      '#ajax' => [
        'callback' => [$this, 'submitOtpFormAjax'],
        'event' => 'click',
        'url' => Url::fromRoute('lawyer_tfa.otp_verification_form'),
        'options' => ['query' => ['ajax_form' => 1]],         
      ],*/        
    ]; 
   
    //$form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#cache'] = ['max-age' => 0];  

    return $form;
  }

  /**
   * AJAX callback handler for adding and updating cart items.
   */
  public function submitOtpFormAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    // If there are any form errors, re-display the form.
    if ($form_state->hasAnyErrors()) {
        $response->addCommand(new ReplaceCommand('#otp_verification_form', $form));
    } else {
        $session = \Drupal::service('session');
        $otp = $session->get('tfa_otp');
        $otp_entered = $form_state->getValue('otp');
        if($otp_entered == $otp) { 
          $tfa_account = $session->get('tfa_account');
          user_login_finalize($tfa_account);
          $response->addCommand(new CloseModalDialogCommand());
          $response->addCommand(new RedirectCommand('/stream'));
        }
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $session = \Drupal::service('session');
    $otp = $session->get('tfa_otp');
    if ($form_state->getValue('otp')  != $otp) {
        $form_state->setErrorByName('otp', t('Wrong OTP'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $session = \Drupal::service('session');
    $otp = $session->get('tfa_otp');
    $otp_entered = $form_state->getValue('otp');
    if($otp_entered == $otp) { 
      $tfa_account = $session->get('tfa_account');
      user_login_finalize($tfa_account);
      $form_state->setRedirect('<front>');
      return;      
    }        
  }

}
