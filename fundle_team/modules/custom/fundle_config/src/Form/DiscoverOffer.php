<?php

namespace Drupal\fundle_config\Form;

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
use Drupal\node\Entity\Node;
////
use Drupal\Core\Form\FormBuilderInterface;



/**
 * Description of lifafaAward
 *
 *
 */
class DiscoverOffer extends FormBase {
    //put your code here
     /**
   * {@inheritdoc}
   */
  public function getFormId() {
      return 'discover_offer';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state, $data = array()) {     
    
      
      
      $html='';    
      $filterby = 16;
      $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type'=>'launch_offers','field_mall' => $filterby,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
    }

      $sub_header = $node->field_sub_header->value;
      $header = $node->field_header->value;
      
     $html = '
    <div class="container" style="max-width: 1250px;">
        <div class="gr-2 text-1-web bold pb-10">'.$node->title->value.'</div>
        <h5>'.$header.'</h5>
        <div class="text-2 ul-li">
            '.$node->body->value.'
        </div>
    </div>';
      
    
    $form['#prefix'] = '<div class="container" style="max-width: 1250px;"><h2 class="text-center sec3-title-main">Discover Offers by Malls</h2>
         </div> <div class="tab-container">';          
    
    
    $options = getMallListOptions(); 
    $form['filterby'] = [
      '#type' => 'select',
      '#prefix' => '<div class="container" style="max-width: 1250px;"><div class="tab-navigation">',   
      '#suffix' => "</div></div>",
      //'#title' => $this->t('Select award type'),
      '#title_display' => 'invisible',
      '#attributes' => ['class' => ['fm-in']],
      '#options'=>$options,
      '#required' => FALSE,
      '#default_value' => 16,  
    '#ajax' => [
    'event' => 'change',
    'callback' => '::createOwnAwards',
    'wrapper' => 'award_name',
  ], 
  
    ];  
   
     
    
     $form['debug'] = [
      '#type' => 'container',
      '#prefix' => '<div id="tab-1" class="stab-content">'.$html,
      '#suffix' => "</div>",    
      '#attributes' => [
        'id' => ['debug-out'],
        //'style'=>["max-width: 1250px;"],
      ],
    ];
     
      $form['#suffix'] = "</div>"; 
    
          
    //$form['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $form['#cache'] = ['max-age' => 0];  
    //$form['#theme'] = "create_award_form";    
    return $form;        
  }
 
 /**
   * AJAX callback handler for adding and updating cart items.
   */

public function createOwnAwards(array &$form, FormStateInterface $form_state) {
      $response = new AjaxResponse();
      $filterby = $form_state->getValue('filterby');    
     
      
      
       $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type'=>'launch_offers','field_mall' => $filterby,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
    }

      $sub_header = $node->field_sub_header->value;
      $header = $node->field_header->value;
      
     $html = '
    <div class="container" style="max-width: 1250px;">
        <div class="gr-2 text-1-web bold pb-10">'.$node->title->value.'</div>
        <h5>'.$header.'</h5>
        <div class="text-2 ul-li">
            '.$node->body->value.'
        </div>
    </div>';
    
      $settings = ['my-setting' => 'setting',]; 
       $response->addCommand(new HTMLCommand('#debug-out', $html ));      
      $form_state->setRebuild(True);
    return $response;
     
}

/**
 * @param array $form
 * @param FormStateInterface $form_state
 */
public function submitForm(array &$form, FormStateInterface $form_state)
{
      
        return true;
}

  
  
  
  
  
  

}
