<?php

namespace Drupal\employee_award\Form;

//use Drupal\Core\Form\FormBase;
//use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Url;
////
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\lifafa_store\Controller\LifafaStoreController;


/**
 * Description of lifafaAward
 *
 *
 */
class lifafaAward extends FormBase {
    //put your code here
     /**
   * {@inheritdoc}
   */
  public function getFormId() {
      return 'employee_award_send_award';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state, $data = array()) {     
      
    if ($form_state->has('page') && $form_state->get('page') == 2) {
        return self::formPageTwo($form, $form_state);
    }
      $form_state->set('page', 1);
     $options = $this->getAllAwardName(); 
    $form['award_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Select award type'),
      '#title_display' => 'invisible',
      '#attributes' => ['class' => ['fm-in']],
      '#options'=>$options,
      '#required' => TRUE,
      '#default_value' => $form_state->getValue('award_type', ''),  
    '#ajax' => [
    'event' => 'change',
    'callback' => '::createOwnAwards',
    'wrapper' => 'award_name',
  ], 
  
    ];  
    
        
    $form['award_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Award Name'),      
      '#attributes' => ['class' => ['fm-in']],      
      '#title_display' => 'invisible',
      '#default_value' => $form_state->getValue('award_name', ''),  
      '#placeholder' => t('Award Name'),      
       '#states' => array(
    'visible' => array(
      array(':input[name="award_type"]' => array('value' => 'create_your_own')),
      array(':input[name="award_type"]' => array('value' => '')),
    ),
  )  
        
    ];
      // $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
      if(\Drupal::currentUser()->isAuthenticated()){
        $idToken = $_SESSION['idToken'];
        if (empty($idToken)) {
           return '';
       }
       $tokenArray = explode(".", $idToken);
       if (!isset($tokenArray[1])) {
           return null;
       }
       $parsedJwt = base64_decode($tokenArray[1]);
       if (!$parsedJwt) {
           return null;
       }
       $userDetailsArray = json_decode($parsedJwt, true);
       if (!$userDetailsArray) {
           return null;
       }
       $name = $userDetailsArray["name"]; 
      $company_name = $userDetailsArray['companyName'];
      $email = $userDetailsArray["email"];
      }
       
   // print_r($userdata);
   
    
   // $company_name = $userdata['company_name'];
    $form['sender_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Sender Name'),
     //'#required' => TRUE,        
      '#attributes' => ['class' => ['fm-in']],         
      //'#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => t('Sender Name'),
     '#default_value' => ($form_state->getValue('sender_name',''))?$form_state->getValue('sender_name',''):$name,
    ];
    
    $form['sender_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Enter sender email'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['fm-in']],
      //'#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
    //  '#default_value' => $email,
      '#default_value' => ($form_state->getValue('sender_email',''))?$form_state->getValue('sender_email',''):$email,   
      '#title_display' => 'invisible',
      '#placeholder' => t('Sender Email'),      
    ];
    
 
    $form['company_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Company Name'),
       '#attributes' => ['class' => ['fm-in']],
     // '#required' => TRUE,
//      '#attributes' => ['class' => ['otp-field']],
//      '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => t('Company Name'),
    //  '#default_value' => $form_state->getValue('company_name', ''), 
    '#default_value' => ($form_state->getValue('company_name',''))?$form_state->getValue('company_name',''):$company_name,
    ];
        
    $today = date("Y-m-d");    
    $form['award_date'] = [
        '#type' => 'date',        
        '#date_date_format' => 'd/m/Y',        
        '#attributes' => ['class' => ['fm-in']],     
        '#title_display' => 'invisible',
        '#placeholder' => t('Award Date'),
        '#default_value' => $form_state->getValue('award_date', $today),         
    ];
    
    $form['recipient_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Recipient Name'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['fm-in']],     
//    '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => $this->t('Recipient Name'),
      '#default_value' => $form_state->getValue('recipient_name', ''), 
    ];
    
    $form['recipient_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Enter Recipient email'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['fm-in']],
//    '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => t('Recipient Email'),
      '#default_value' => $form_state->getValue('recipient_email', ''),   
//    '#size' => 6,
//    '#maxlength' => 6,
    ];
    
    
    $form['award_template'] = [
      '#type' => 'radios',
      '#title' => $this->t('Select Award Template'),
     // '#required' => TRUE,
      '#attributes' => ['class' => ['fm-in']],
//    '#attributes' => ['class' => ['otp-field']],
      '#wrapper' =>[],
      '#title_display' => 'invisible',
      '#placeholder' => t('Select Award Template'),
      '#options' => array('1' => 'Template1', '2' => 'Template2', '3' => 'Template3', '4' => 'Template4','5' => 'Template5'),
       //'#default_value' => '1',
       '#default_value' => $form_state->getValue('award_template', '1'),
//      '#size' => 6,
//      '#maxlength' => 6,
    ];
    
    $form['award_heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Award Name'),
      '#required' => TRUE,
        '#attributes' => ['class' => ['fm-in']],
//      '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
       '#title_display' => 'invisible',
      '#placeholder' => t('Award Heading'),
      '#default_value' => $form_state->getValue('award_heading', ''),
    ];
    
    $form['award_body'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Enter Body'),
      '#required' => TRUE,
      '#attributes' => ['class' => ['fm-in fm-textarea'],'maxlength' => 500],      
        '#default_value' => $form_state->getValue('award_body', ''),
//      '#wrapper_attributes' => ['class' => ['otp-field-wrapper']],
      '#title_display' => 'invisible',
      '#placeholder' => t('Award Body (Max. 500 character limit)'),
    ];
   
        
    $form['actions']['next'] = [
    '#type' => 'submit',
    '#attributes' => ['class' => ['btn btn-primary']],   
    '#button_type' => 'primary',
    '#value' => $this->t('Preview'),
    '#submit' => ['::submitPageOne'],
    '#validate' => ['::validatePageOne'],
  ];
          
    //$form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#cache'] = ['max-age' => 0];  
  $form['#theme'] = "create_award_form";    
    return $form;        
  }
  
  
  /**
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 * @return array
 *   The render array defining the elements of the form.
 */
public function formPageTwo(array &$form, FormStateInterface $form_state) { 
  $form['description'] = [
    '#type' => 'item',
    //'#title' => $this->t('Page @page',['@page'=>$form_state->get('page')]),
    '#default_value' => 'yes',
  ];
  $email_data = [];
  $form_values = $form_state->getValue(array());
 // dump($form_values); 
  
  $email_data['award_type'] = $form_state->getValue('award_type');  
  $templateHtml = getXMailMessageBody($form_values);
    
//  $form_state
//    ->setValues($form_state->get('page_values'))
//    ->set('page', 3)
//    ->setRebuild(TRUE);
  
   $form_state
    ->set('page_values', [
      'award_heading' => $form_state->getValue('award_heading'),
      'award_type' => $form_state->getValue('award_type'),
      'award_name' => $form_state->getValue('award_name'),
      'sender_name' => $form_state->getValue('sender_name'),
      'sender_email' => $form_state->getValue('sender_email'),        
      'company_name' => $form_state->getValue('company_name'),
      'recipient_name' => $form_state->getValue('recipient_name'), 
      'recipient_email' => $form_state->getValue('recipient_email'),
      'award_template' => $form_state->getValue('award_template'),
      'award_heading' => $form_state->getValue('award_heading'),
      'award_body' => $form_state->getValue('award_body'),
      'award_date' => $form_state->getValue('award_date'),         
    ])
    ->set('page', 3)
    ->setRebuild(TRUE);
   
   
  $form['color'] = array(
  '#markup' => $templateHtml,  
  );  
  
  $form['back'] = [
    '#type' => 'submit',
    '#attributes' => ['class' => ['btn btn-primary']],    
    '#value' => $this->t('Back'),
    '#submit' => ['::pageTwoBack'],
    '#limit_validation_errors' => [],
      '#prefix' => '<div class="steps pb-30 clear">
             <div class="container container-1500 text-center">',
  ];
  $form['submit'] = [
    '#type' => 'submit',
    '#attributes' => ['class' => ['btn btn-primary']],    
    '#button_type' => 'primary',
    '#value' => $this->t('Send'),          
   '#suffix' => '</div></div>',     
  ];  
   $form['#cache'] = ['max-age' => 0]; 
    $form['#theme'] = "create_award_prev_form"; 
  return $form;
}
  
  
    /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
      
      
      
    //  dump($form_state->getValues());die;
    foreach ($form_state->getValues() as $key => $value) {
    //   print_r($value);
      // @TODO: Validate fields.
    }
    
    parent::validateForm($form, $form_state);
  }
  
  
  /**
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 */
public function submitPageOne(array &$form, FormStateInterface $form_state) {
    
//    foreach ($form_state->getValue() as $key=>$value){
//        echo "this ".$value."<br>";
//    }
//    
    
   //echo  $this->getXMailMessageBody(2);
   
   //die;
   
 $form_state
    ->set('page_values', [
      'award_heading' => $form_state->getValue('award_heading'),
      'award_type' => $form_state->getValue('award_type'),
      'award_name' => $form_state->getValue('award_name'),
      'sender_name' => $form_state->getValue('sender_name'),
      'sender_email' => $form_state->getValue('sender_email'),        
      'company_name' => $form_state->getValue('company_name'),
      'recipient_name' => $form_state->getValue('recipient_name'), 
      'recipient_email' => $form_state->getValue('recipient_email'),
      'award_template' => $form_state->getValue('award_template'),
      'award_heading' => $form_state->getValue('award_heading'),
      'award_body' => $form_state->getValue('award_body'),      
       'award_date' => $form_state->getValue('award_date'),       
        
    ])
    ->set('page', 2)
    ->setRebuild(TRUE);
}
  
  
 /**
   * AJAX callback handler for adding and updating cart items.
   */

public function createOwnAwards(array &$form, FormStateInterface $form_state) {
      $response = new AjaxResponse();
      $award_type = $form_state->getValue('award_type');    
    if(!empty($award_type) && $award_type=='create_your_own'){        
        $response->addCommand(new CssCommand('.award_name', ['display' => 'block']));        
        //$form_state->setValue(['award_name','#access, TRUE]);
        //$form_state->setValue(['award_name', '#access'], TRUE);
    }else{        
        $response->addCommand(new CssCommand('.award_name', ['display' => 'none']));        
        //$form_state->setValue(['award_name',['#access', FALSE]]);
    }    
    //Rebuild    
    $form_state->setRebuild(True);
    return $response;
}

  public function createOwnAward(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
   //echo "ASdasd";die;
    $award_type = $form_state->getValue('award_type');
    
    //dump($award_type);die;
    
    if(!empty($award_type) && $award_type=='create_your_own'){
        echo "ASdasdasd";die;
    return true;    
//         $text = 'Failed to connect ftp server, Please check added ftp detail!';                
//                $color = 'red';
//                $ajax_response->addCommand(new HtmlCommand('#testFtpdetail', $text));
//                $ajax_response->addCommand(new InvokeCommand('#testFtpdetail', 'css', array('color', $color)));
//                return $ajax_response;
        
    }
//    die("asas");
//    // If there are any form errors, re-display the form.
//    if ($form_state->hasAnyErrors()) {
//        $response->addCommand(new ReplaceCommand('#otp_verification_form', $form));
//    } else {
//        $session = \Drupal::service('session');
//        $otp = $session->get('tfa_otp');
//        $otp_entered = $form_state->getValue('otp');
//        if($otp_entered == $otp) { 
//          $tfa_account = $session->get('tfa_account');
//          user_login_finalize($tfa_account);
//          $response->addCommand(new CloseModalDialogCommand());
//          $response->addCommand(new RedirectCommand('<front>'));
//          //$response->addCommand(new RedirectCommand('/stream'));
//        }
//    }
//    return $response;
  }
  
/**
 * @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 */
public function pageTwoBack(array &$form, FormStateInterface $form_state) {
  $form_state
    ->setValues($form_state->get('page_values'))
    ->set('page', 1)
    ->setRebuild(TRUE);
}

/**
 * @param array $form
 * @param FormStateInterface $form_state
 */
public function submitForm(array &$form, FormStateInterface $form_state)
{
    $form_values = $form_state->getValue(array());
    $form_values = $form_state->get('page_values');    
       $templateHtml = getXMailMessageBody($form_values);       
       
//    $print_engine = \Drupal::service('plugin.manager.entity_print.print_engine')->createSelectedInstance('pdf');
//    $print_engine->addPage($templateHtml);
//    
//    
//    // Create pdf file and store file
//    file_put_contents('sites/default/files/MyFormsOfAssistance.pdf', $print_engine->addPage($templateHtml));
//
//
//    // Attach pdf file to email params
////    $file = new \stdClass();
////    $file->uri = 'sites/default/files/MyFormsOfAssistance.pdf';
////    $file->filename = 'MyFormsOfAssistance.pdf';
////    $file->filemime = 'application/pdf';
////    $params['attachments'][] = $file;
//    try{
//        $print_engine->addPage($templateHtml);
//        $print_engine->send('sites/lifafa.team/files/MyFormsOfAssistance.pdf');
//        //echo file_put_contents('sites/lifafa.team/files/MyFormsOfAssistance.pdf', );die;
//    } catch (Exception $ex) {
//        
//        p_r($ex);
//    }
//    
//    $params['context']['attachments'] = [
//    'filecontent' => file_put_contents('sites/lifafa.team/files/MyFormsOfAssistance.pdf', $print_engine->addPage($templateHtml)),
//    'filename' => 'MyFormsOfAssistance.pdf',
//    'filemime' => 'application/pdf',     
//    ];
//    print_r($params);die;
//    //echo $print_engine->send('mydocument.pdf');
//    //die;



        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'employee_award';
        $key = 'award_mail';
        $to =  trim($form_values['recipient_email']);//\Drupal::currentUser()->getEmail();
        $params['message'] = $templateHtml;
        $sendername= $form_values['sender_name'];
        $subject = "new award received from $sendername";
        $params['subject'] = $subject;        
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;

        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        if ($result['result'] !== true) {
            drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
        } else {
            //drupal_set_message(t('Your message has been sent.'));
            // $form_state['redirect'] = 'employee_award.employee_award_controller_sendgiftcardpage';
        // $form_state->setRedirect('store/%25/voucher');
       // $form_state->setRedirect(employee_award.employee_award_controller_sendgiftcardpage);
         // $form_state->setRedirectUrl(\Drupal\Core\Url);
           // $routename='employee_award.employee_award_controller_sendgiftcardpage';
            //$form_state->setRedirectUrl($routename);
          
          $url = Url::fromRoute('employee_award.employee_award_controller_sendgiftcardpage');
          $form_state->setRedirectUrl($url);
        }                
        return true;
}


 /* @param array $form
 *   An associative array containing the structure of the form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The current state of the form.
 */
public function validatePageOne(array &$form, FormStateInterface $form_state) {
    
    foreach ($form_state->getValues() as $key => $value) {
       //echo "<pre>";print_r($value);
      // @TODO: Validate fields.
    }
    
    
//  $title = $form_state->getValue('first_name');
//  if (strlen($title) < 5) {
//    $form_state->setErrorByName('first_name', $this->t('The first name must be at least 5 characters long.'));
//  }
}
  /**
   * 
   * @return type
   */
  public function getAllAwardName(){      
        $query = \Drupal::entityQuery('taxonomy_term');
        $query->condition('vid', "award_type");
       $query->sort('weight' , 'ASC'); 
        $tids = $query->execute();
        $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);        
        foreach ($terms as $term) {            
            $id = $term->id();
        $remove[] = "'";
        $remove[] = '"';
        $remove[] = "-";
        $remove[] = " ";

        $optionVal = str_replace( $remove, "_", strtolower($term->name->value) );          
        //$option[$id] = $term->name->value;
         $option[$optionVal] = $term->name->value;
        }
        return $option;        
  }
  
  
  
//  
//  //array &$form, FormStateInterface $form_state
//    public function usernameValidateCallback(array &$form, FormStateInterface $form_state) {
//
//        
//        // Instantiate an AjaxResponse Object to return.                
//        $ajax_response = new AjaxResponse();        
//        $logged_user_id = \Drupal::currentUser()->id();                       
//        $obj = new TestFtpDetailController();
//        $data = $obj->getConsumerData($logged_user_id);
//         //dd($data['filename']);
//         //die("ASd");
//        
//        //$filename = $_SERVER['DOCUMENT_ROOT'] . '/sites/default/files/sstest.text';
//        $filename = $data['filename'];
//        try {
//            if (empty($ftpDetail) && empty($filename)) {
//                return false;
//            }
//
//            $connection_type = $form_state->getValue('connection_type');
//            $user = $form_state->getValue('username');
//            $password = $form_state->getValue('password');
//            $host = $form_state->getValue('end_point');            
//            $status = $form_state->getValue('status');            
//            $port = ($form_state->getValue('port') && $form_state->getValue('port') >0)?$form_state->getValue('port'): 21;
//            
//            if(!$status){                
//                $text = 'Your ftp detail Inactive. Please active';                
//                $color = 'red';
//                $ajax_response->addCommand(new HtmlCommand('#testFtpdetail', $text));
//                $ajax_response->addCommand(new InvokeCommand('#testFtpdetail', 'css', array('color', $color)));
//                return $ajax_response;
//            }
//            
//            if($user=='' || $password=='' ||$host==''){                
//                $text = 'Failed to connect ftp server, Please check added ftp detail!';                
//                $color = 'red';
//                $ajax_response->addCommand(new HtmlCommand('#testFtpdetail', $text));
//                $ajax_response->addCommand(new InvokeCommand('#testFtpdetail', 'css', array('color', $color)));
//                return $ajax_response;
//            }
//            
//            $ftpConn = ftp_connect($host);
//            
//            if (!empty($ftpConn)) {
//                $login = ftp_login($ftpConn, $user, $password);
//                ftp_pasv($ftpConn, TRUE);
//                
//            } else {
//                //\Drupal::logger('upload_file_on_server')->notice("Something Went wrong to connect FTP!");
//                 $text = 'Something Went wrong to connect FTP!';
//                //$text = 'Failed to create. Please check FTP detail.';
//               $color = 'red';
//            }
//
//
//            // check connection
//            if ((!$ftpConn) || (!$login)) {
//                $text = 'FTP connection has failed! Attempted to connect to ' . $host . ' for user ' . $user . '.';
//                $color = 'red';                
//            } else {
//                //'FTP connection was a success.';
//                $destinationFileName = "dwx_".time().'_test.csv';
//                
//                if (ftp_put($ftpConn, $destinationFileName, $filename, FTP_ASCII)) {                   
//                    ftp_close($ftpConn);
//                    $text = 'File uploaded successfully on FTP server.';
//                    $color = 'green';                   
//                } else {                                        
//                    $text = 'Failed to create. Please check FTP detail.';
//                    $color = 'red';                   
//                }
//            }
//        } catch (Exception $ex) {
//            $text = 'Failed to create. Please check FTP detail.';
//            $color = 'red';
//            //\Drupal::logger('upload_file_on_server')->notice($ex->getMessage());
//        }
//       
//        $ajax_response->addCommand(new HtmlCommand('#testFtpdetail', $text));
//
//        // CssCommand did not work.
//        //$ajax_response->addCommand(new CssCommand('#edit-user-name--description', array('color', $color)));
//        // Add a command, InvokeCommand, which allows for custom jQuery commands.
//        // In this case, we alter the color of the description.
//        $ajax_response->addCommand(new InvokeCommand('#testFtpdetail', 'css', array('color', $color)));
//
//        // Return the AjaxResponse Object.
//        return $ajax_response;
//    }
    
    

}
