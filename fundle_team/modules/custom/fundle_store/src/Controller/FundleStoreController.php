<?php

namespace Drupal\fundle_store\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
//use Drupal\fundle_store\Controller\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Drupal\node\NodeInterface;


/**
 * Class LifafaStoreController.
 */
class FundleStoreController extends ControllerBase {

    /**
     * Getstore.
     *
     * @return string
     *   Return Hello string.
     */
    //public function __construct(PrivateTempStoreFactory $temp_store_factory) {        
        public function __construct(PrivateTempStoreFactory $temp_store_factory) {  
      
        if(\Drupal::currentUser()->isAuthenticated()){
            
//            $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');            
//            //$storeId = $this->getStoreTerminalId($_SESSION['idToken']);           
//            $storeId = $this->getStoreTerminalId(1235);                       
//            $tempstore->set('storeTerminalId', $storeId);                        
//            setcookie('storeid', $storeId,time() + (86400 * 30), "/"); // 86400 = 1 day            
        }
      
        if (\Drupal::currentUser()->isAnonymous()) {
            // Anonymous user...
        }
    }
    
     public static function create(ContainerInterface $container) {
    return new static(
      $container->get('user.private_tempstore')
    );
  }
 

    public function getStore(Request $request) {

        $requestUri = $request->getRequestUri();
        global $base_url;
       // $storeUrl = $this->getStoreUrl($_SESSION['idToken']);
      $storeUrl = $base_url.'/123544/'.'333/home';
     
        $response = new RedirectResponse($storeUrl);
        $response->send();
        return new Response();
    }
    
    public function getBannerData($mallId=''){
      
        $bannerData=[];                
        $current_time = \Drupal::time()->getCurrentTime();    
        $currDate = date('Y-m-d', $current_time); 
         
        $storage = \Drupal::entityTypeManager()
        ->getStorage('node');
        $qry = $storage->getQuery()
        ->condition('type','welcome_banners')
//        ->condition('field_isbanner',1)
//        ->condition('field_mall_id',$mallId)
        ->condition('status', 1)
//        ->condition('field_banner_start_date', $currDate,'<=')
//        ->condition('field_banner_end_date', $currDate, '>=' )     
        ->execute();        
        $nodes_deal = $storage->loadMultiple( $qry );       
        if(!empty($nodes_deal)){
            foreach ($nodes_deal as $deals){
                
               $nid = $deals->nid->value;
               $deal_banner_id =$deals->field_image->target_id;
               $banner_heading = $deals->field_banner_heading->value;               
                if(!empty($deal_banner_id)){                 
                      $deal_banner_url = getFileUrl($deal_banner_id);
                      $bannerData[$nid]['bannerUrl'] = $deal_banner_url;
                }
                $bannerData[$nid]['banner_heading'] = $banner_heading;
            }
        }
         
        
        return $bannerData;
    }
    
     public function welcomePageBanner($store_id) {

       // $requestUri = $request->getRequestUri();
       // global $base_url;
        $data = $this->getBannerData($store_id);
        return [
            '#theme' => 'welcomebanner',
            '#content' => $data,
        ];
        
       // $storeUrl = $this->getStoreUrl($_SESSION['idToken']);
      $storeUrl = $base_url.'/123544/'.'333/home';
     
        $response = new RedirectResponse($storeUrl);
        $response->send();
        return new Response();
    }

    public function pageNotFound() {    
        
         //$storeId = $request->get('id');
        
        return [
            '#theme' => 'page_not_found',
            '#storedata' => $data,
        ];
    }
    public function parkHomePage($store_id,$mall_id) {
        //echo $store_id,$mall_id;
        
        
//       return [
//      '#markup' => 'Hello, world',
//    ];  
//    $build['#theme'] = 'store_home_page';
//    //populate your build renderable array..
//    return $build;
//    $response = new RedirectResponse('<front>');
//        $response->send();
//        return new Response();
        
//        $storeId = $request->get('id');
        $data = $this->getParkData($mall_id);      
//        $storeSessionId =getStoreIdFromSession();           
//        if($storeSessionId!=$storeId){
//            $response = new RedirectResponse('system.404');
//            $response->send();
//            return new Response();
//        }

        
        return [
            '#theme' => 'parkpage',
            '#storedata' => $data,
        ];
    }
    public function storeHomePage($store_id,$mall_id) {
        //echo $store_id,$mall_id;
        
        
//       return [
//      '#markup' => 'Hello, world',
//    ];  
//    $build['#theme'] = 'store_home_page';
//    //populate your build renderable array..
//    return $build;
//    $response = new RedirectResponse('<front>');
//        $response->send();
//        return new Response();
        
//        $storeId = $request->get('id');
        $data = $this->getStoreData($mall_id);      
//        $storeSessionId =getStoreIdFromSession();           
//        if($storeSessionId!=$storeId){
//            $response = new RedirectResponse('system.404');
//            $response->send();
//            return new Response();
//        }

        
        return [
            '#theme' => 'mallpage',
            '#storedata' => $data,
        ];
    }
    
    public function bookHomePage($store_id,$mall_id) {
        //echo $store_id,$mall_id;
        
        
//       return [
//      '#markup' => 'Hello, world',
//    ];  
//    $build['#theme'] = 'store_home_page';
//    //populate your build renderable array..
//    return $build;
//    $response = new RedirectResponse('<front>');
//        $response->send();
//        return new Response();
        
//        $storeId = $request->get('id');
        $data = $this->getBookData($mall_id);      
//        $storeSessionId =getStoreIdFromSession();           
//        if($storeSessionId!=$storeId){
//            $response = new RedirectResponse('system.404');
//            $response->send();
//            return new Response();
//        }

        
        return [
            '#theme' => 'bookpage',
            '#storedata' => $data,
        ];
    }
    
    public function eatHomePage($store_id,$mall_id) {
        //echo $store_id,$mall_id;
        
        
//       return [
//      '#markup' => 'Hello, world',
//    ];  
//    $build['#theme'] = 'store_home_page';
//    //populate your build renderable array..
//    return $build;
//    $response = new RedirectResponse('<front>');
//        $response->send();
//        return new Response();
        
//        $storeId = $request->get('id');
        $data = $this->getEatData($mall_id);      
//        $storeSessionId =getStoreIdFromSession();           
//        if($storeSessionId!=$storeId){
//            $response = new RedirectResponse('system.404');
//            $response->send();
//            return new Response();
//        }

        
        return [
            '#theme' => 'eatpage',
            '#storedata' => $data,
        ];
    }
    
    public function shopHomePage($store_id,$mall_id) {

        $data = $this->getShopData($mall_id);      
        
        return [
            '#theme' => 'shoppage',
            '#storedata' => $data,
        ];
    }

    /**
     * @name getStoreTerminalID
     * @desc this is parse session data into array
     * @param type $token
     * @return url
     */
    protected function getStoreUrl($token = '') {
               
        global $base_url;
//        if (empty($token)) {
//            $storeId = (!empty($storeId))?$storeId:1234;
//          return   $url = $base_url . '/store/' . $storeId . '/home';
//            return '';
//        }
        try {
//        $opts = [
//            "http" => [
//                "method" => "GET",
//                "header" => "Authorization: bearer ".$token
//            ],
//            "ssl" => [
//                "verify_peer" => false,
//                "verify_peer_name" => false,
//            ],
//        ];
//
//        $file = file_get_contents('https://lauth.lifafa.team/auth/realms/Lifafa/protocol/openid-connect/userinfo', false, stream_context_create($opts));
//        $data = json_decode($file);
            
            $storeId = getStoreUrl();
            $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
             //clear storage
            $tempstore->delete('userClaimperks'); 
            $storeId = $this->getStoreTerminalId($token);
            //$this->tempStore->set('storeTerminalId', $storeId);
             $tempstore->set('storeTerminalId', $storeId);
           // $storeId = (!empty($storeId))?$storeId:1234;
            $url = $base_url . '/store/' . $storeId . '/home';            
            return $url;
        } catch (Exception $ex) {
            return $ex->getMessages();
        }
    }

    
    
    public function checkExtingToken($urlId=''){
        // Return 404 Page If URL token does not match        
        $response = new RedirectResponse($storeUrl);
        $response->send();                
        if(empty($urlId)){
            return new Response();
        }
        if($urlId!=$sessionId && \Drupal::currentUser()->isAuthenticated()){
            // Redirect 404 Invalid pae
            return new Response();
        }
    }
    
//  // Read some temporary data
//  static public function getStoreId() {
//    return $this->tempStore->get('storeTerminalId');    
//  }
  
    
    static public function getStoreData($mallId){        
        $data = [];
        if(empty($mallId)){return ; }
        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'mall', 'field_mall_id' => $mallId,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
        //dump($node);die;
        $_SESSION['lifafa_store']['store_terminal_id'] = $node->id();;
        
        $data['title'] = $node->title->value;        
        $data['store_id'] = $node->field_store_id->value;
        //$data['store_name'] = $node->field_store_name->value;        
       //$logoId = $node->field_store_logo->target_id;   
        //$data['store_banner'] = $node->field_store_banner->target_id; 
        //$bannerId = $node->field_store_banner->target_id;
        

//        $file = \Drupal\file\Entity\File::load($bannerId);
//        $path = $file->getFileUri();
//        $url = \Drupal\Core\Url::fromUri(file_create_url($path))->toString();
//        $data['store_banner']=$url;
//        
//        $file = \Drupal\file\Entity\File::load($logoId);
//        $path = $file->getFileUri();
//        $url = \Drupal\Core\Url::fromUri(file_create_url($path))->toString();
//        $data['store_logo']=$url;
        
//        $paragraph = $node->field_store_slider->getValue();        
//        $data['store_slider'] = [];
//        foreach ( $paragraph as $element ) {
//            $p = \Drupal\paragraphs\Entity\Paragraph::load( $element['target_id'] );            
//            
//            $data['store_slider'][$element['target_id']]['banner_heading'] = $p->field_banner_heading->value;
//            
//            $mainImagesId = $p->field_banner_image->target_id;                      
//            $file = \Drupal\file\Entity\File::load($mainImagesId);
//            $path = $file->getFileUri();
//            $mainImageurl = \Drupal\Core\Url::fromUri(file_create_url($path))->toString();
//            
//            
//            $data['store_slider'][$element['target_id']]['banner_image'] = $mainImageurl;
//            $data['store_slider'][$element['target_id']]['banner_subheading'] = $p->field_banner_subheading->value;            
//        }
        //dump($data);die;
        
        //dump($node);
        $paragraph_blocks = $node->field_store_blocks->getValue();
        //dump($paragraph_blocks);
        foreach ( $paragraph_blocks as $element_block ) {
            $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
            //dump($pblock);
            $data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;;
            $data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
            $data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;            
        }
        
        //dump($data);
        
        //echo $url = \Drupal\image\Entity\ImageStyle::load('')->buildUrl($file->getFileUri());
        //echo "<pre>"; print_r($data);die;
        return $data;                    
    }

    }
    
    static public function getParkData($mallId){        
        $data = [];
        if(empty($mallId)){return ; }
        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'park', 'field_mall_id' => $mallId,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
      
        $_SESSION['lifafa_store']['store_terminal_id'] = $node->id();
        $data['title'] = $node->title->value;        
        $data['store_id'] = $node->field_store_id->value;  
        $logoId = $node->field_store_logo->target_id;   
       
        $bannersParagraphBlocks = $node->field_park_category_banners->getValue();        
        if(!empty($bannersParagraphBlocks)){
            foreach ( $bannersParagraphBlocks as $element_block ) {
                $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
                //  dump($pblock);
                $logoId = $pblock->field_banner_image->target_id;
                $file = \Drupal\file\Entity\File::load($logoId);
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path),['https' => 
                    !empty(getenv('APP_ENV')) ? true : false
                    ])->toString();
                }
                $data['banner_blocks'][$element_block['target_id']]['banner_image'] = $url;
                $data['banner_blocks'][$element_block['target_id']]['banner_heading'] = $pblock->field_banner_heading->value;
                $data['banner_blocks'][$element_block['target_id']]['banner_subheading'] = $pblock->field_banner_subheading->value;            
            }
        }
        
        //dump($node);
        $paragraph_blocks = $node->field_park_block->getValue();
        //dump($paragraph_blocks);
        foreach ( $paragraph_blocks as $element_block ) {
            $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
            //dump($pblock);
            $data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;;
            $data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
            $data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;            
        }
        return $data;                    
    }

    }
    
    static public function getShopData($mallId){        
        $data = [];
        if(empty($mallId)){return ; }
        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'shop', 'field_mall_id' => $mallId,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
      
        $_SESSION['lifafa_store']['store_terminal_id'] = $node->id();
        $data['title'] = $node->title->value;        
        $data['store_id'] = $node->field_store_id->value;  
        $logoId = $node->field_store_logo->target_id;   
       
        
        $bannersParagraphBlocks = $node->field_shop_category_banners->getValue();        
        if(!empty($bannersParagraphBlocks)){
            foreach ( $bannersParagraphBlocks as $element_block ) {
                $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
                //  dump($pblock);
                $logoId = $pblock->field_banner_image->target_id;
                $file = \Drupal\file\Entity\File::load($logoId);
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path),['https' => 
                    !empty(getenv('APP_ENV')) ? true : false
                    ])->toString();
                }
                $data['banner_blocks'][$element_block['target_id']]['banner_image'] = $url;
                $data['banner_blocks'][$element_block['target_id']]['banner_heading'] = $pblock->field_banner_heading->value;
                $data['banner_blocks'][$element_block['target_id']]['banner_subheading'] = $pblock->field_banner_subheading->value;            
            }
        }
        //dump($node);
        $paragraph_blocks = $node->field_shop_blocks->getValue();
        //dump($paragraph_blocks);
        foreach ( $paragraph_blocks as $element_block ) {
            $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
            //dump($pblock);
            $data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;;
            $data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
            $data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;            
        }
        return $data;                    
    }

    }
    
    static public function getEatData($mallId){        
        $data = [];
        if(empty($mallId)){return ; }
        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'eat', 'field_mall_id' => $mallId,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
      
        $_SESSION['lifafa_store']['store_terminal_id'] = $node->id();
        $data['title'] = $node->title->value;        
        $data['store_id'] = $node->field_store_id->value;  
        $logoId = $node->field_store_logo->target_id;   
       
        
        
        $bannersParagraphBlocks = $node->field_category_banners->getValue();        
        if(!empty($bannersParagraphBlocks)){
            foreach ( $bannersParagraphBlocks as $element_block ) {
                $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
                //  dump($pblock);
                $logoId = $pblock->field_banner_image->target_id;
                $file = \Drupal\file\Entity\File::load($logoId);
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path),['https' => 
                    !empty(getenv('APP_ENV')) ? true : false
                     ])->toString();
                }
                $data['banner_blocks'][$element_block['target_id']]['banner_image'] = $url;
                $data['banner_blocks'][$element_block['target_id']]['banner_heading'] = $pblock->field_banner_heading->value;
                $data['banner_blocks'][$element_block['target_id']]['banner_subheading'] = $pblock->field_banner_subheading->value;            
            }
        }
        
        $paragraph_blocks = $node->field_eat_blocks->getValue();
        //dump($paragraph_blocks);
        foreach ( $paragraph_blocks as $element_block ) {
            $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
            //dump($pblock);
            $data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;;
            $data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
            $data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;            
        }
        return $data;                    
    }

    }
    
    static public function getBookData($mallId){        
        $data = [];
        if(empty($mallId)){return ; }
        
        $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadByProperties(['type' => 'book', 'field_mall_id' => $mallId,'status'=>1]);
        
    if (!empty($nodes) && $node = reset($nodes)) {       
        $data['id'] = $node->id();  
      
        $_SESSION['lifafa_store']['store_terminal_id'] = $node->id();
        $data['title'] = $node->title->value;        
        $data['store_id'] = $node->field_store_id->value;  
        $logoId = $node->field_store_logo->target_id;   
       
        $bannersParagraphBlocks = $node->field_book_category_banners->getValue();        
        if(!empty($bannersParagraphBlocks)){
            foreach ( $bannersParagraphBlocks as $element_block ) {
                $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
                //  dump($pblock);
                $logoId = $pblock->field_banner_image->target_id;
                $file = \Drupal\file\Entity\File::load($logoId);
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path),['https' => 
                    !empty(getenv('APP_ENV')) ? true : false
                     ])->toString();
                }
                $data['banner_blocks'][$element_block['target_id']]['banner_image'] = $url;
                $data['banner_blocks'][$element_block['target_id']]['banner_heading'] = $pblock->field_banner_heading->value;
                $data['banner_blocks'][$element_block['target_id']]['banner_subheading'] = $pblock->field_banner_subheading->value;            
            }
        }
        
        //dump($node);
        $paragraph_blocks = $node->field_book_blocks->getValue();
        //dump($paragraph_blocks);
        foreach ( $paragraph_blocks as $element_block ) {
            $pblock = \Drupal\paragraphs\Entity\Paragraph::load( $element_block['target_id'] );            
            //dump($pblock);
            $data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;;
            $data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
            $data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;            
        }
        return $data;                    
    }

    }
    
    public function getStoreTerminalId($idToken='') {
        
        $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
     
        $userdata['given_name'] = 'Mohit';
        $userdata['family_name'] = 'Gupta';
        $userdata['name'] = 'Mohit Gupta';
        $userdata['email'] = 'csmohitgupta@gmail.com';
        $userdata['storeTerminalId'] = 'inblr2107001s02';
        //$userdata['claim_perks'] = [];
        $tempstore->set('userData', $userdata);        
        
        return 'inblr2107001s02';
//        return 'inblr2107001s03';
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

        if (isset($userDetailsArray['storeTerminalId'])) {
        $userdata['given_name'] = $userDetailsArray['given_name'];
        $userdata['family_name'] = $userDetailsArray['family_name'];
        $userdata['full_name'] = $userDetailsArray['name'];
        $userdata['email'] = $userDetailsArray['email'];
        $userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
        $tempstore->set('userData', $userdata);        
            return strtolower($userDetailsArray['storeTerminalId']);
        }

        return null;
    }
    
    public function getStoreTerminalLogo(Request $request){
        
        $storeId = $request->get('id');        
        $data = [];
            if(empty($storeId)){return ; }
            $nodes = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_store_id' => $storeId,'status'=>1]);
            if ($node = reset($nodes)) {
                $logoId = $node->field_store_logo->target_id;
                $file = \Drupal\file\Entity\File::load($logoId);
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path),['https' => 
                    !empty(getenv('APP_ENV')) ? true : false
                      ])->toString();
                    $data['store_logo']=$url;                    
                    header('Content-type: image/jpeg');
                    echo file_get_contents($url);                    
                    die;                    
                }
            }
    }
    
    
    public function sendPerksClaimEmail(Request $request){
        
       $node_id = $request->get('nodeid');   
       $node_title = $request->get('nodeTitle');   
        $this->updateClaimedPerks($node_id);
        $this->SendEmailToLifafa($request);
        $this->SendEmailToCustomer($node_id,$node_title);
        $response['status'] = json_encode(array("success"));
        
         return new JsonResponse($response);
       return $text;
    }

    public function SendEmailToLifafa($request){
        
       $userdata = getStoreUserData();       
       $node_id = $request->get('nodeid');   
       $node_title = $request->get('nodeTitle'); 
       $requesrUrl = $request->server->get('HTTP_REFERER');
               $given_name =  $userdata["given_name"];
                $family_name = $userdata["family_name"];
                $name = $userdata["name"];
                $email = $userdata["email"];
                $userdata["given_name"];
                $company = $userdata["storeTerminalId"];
        
        $msg ="Hello Team
        
                Following will be picked up from system for Logged in User:
            
                User First Name: $given_name
                    
                User last Name: $family_name
                    
                User Company: $company
                
                User email id: $email
                    
                User phone number: xxxxxxxxxx
                
                Perk Requested: $node_title
                    
                Requested Date: ".date('Y-m-d H:i:s')."
        
            Thanks!
            
            Team Lifafa";        
        
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'lifafa_store';
        $key = 'lifafa_team_perk';
        $to =  'care@lifafa.com';//\Drupal::currentUser()->getEmail();
        $params['message'] = $msg;
        $params['node_title'] = $node_title;
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;

        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        if ($result['result'] !== true) {
            drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
        } else {
            drupal_set_message(t('Your message has been sent.'));
        }
    }
    
    public function SendEmailToCustomer($id,$title){
        
        $userdata = getStoreUserData();  
        $name = $userdata["given_name"]; 
        $email = $userdata["email"]; 
                        
//        $msg ="Dear $name, 
// 
//        Thanks for placing order with us.  
// 
//        Your $title voucher will be processed within 24 hours. 
// 
//        Thanks! 
//        Team Lifafa"; 
        
//        $msg = twig_render_template(
//            drupal_get_path('module', 'lifafa_store') . '/templates/email_templates/sendCustomerEmail.html.twig', [
//            //'theme_hook_original' => 'not-applicable',
//            'given_name' => "{$name}",
//            'title' => "{$title}",
//            'dynamic_key2' => "{test ji}"
//            ]
//        );
//            
        $body_data = [
        '#theme' => 'sendCustomerEmail',
        //'#data' => $params['message']
        '#given_name' => "{$name}",
        '#title' => "{$title}",
        '#dynamic_key2' => "{test ji}"
        ];    
        
       $msg = \Drupal::service('renderer')->render($body_data);
        
        $mailManager = \Drupal::service('plugin.manager.mail');
        $module = 'lifafa_store';
        $key = 'thanks_customer_perk';
        $to = $email; //\Drupal::currentUser()->getEmail();
        $params['message'] = $msg;
        $params['node_title'] = $title;        
        $langcode = \Drupal::currentUser()->getPreferredLangcode();
        $send = true;

        $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
        if ($result['result'] !== true) {
            drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
        } else {
            drupal_set_message(t('Your message has been sent.'));
        }
    }
    
    
    /**
     * 
     * @param type $nodeId
     */
    public function updateClaimedPerks($nodeId){        
        $tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');       
        $data = $tempstore->get('userClaimperks');
        
        if(!empty($data['claim_perks'])){  
                $data['claim_perks'][] = $nodeId;
        }
        else{
              $data['claim_perks'][] = $nodeId;
        }        
        $data2['claim_perks'] =  array_unique($data['claim_perks']);
        $tempstore->set('userClaimperks', $data2);
        return true;
    } 
    
    /**
     * Set Store Logout
     */
    public function setStoreLogout() {
        
        if(isset($_COOKIE['storeid'])){
            $storeId = $_COOKIE['storeid'];            
            $nodes = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_store_id' => $storeId,'status'=>1]);
            if ($node = reset($nodes)) {
                $nid = $node->ID();
                $alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/' . $nid);   
                unset($_COOKIE['storeid']);
                setcookie('storeid', '',time() + (86400 * 30), "/");                
                $response = new RedirectResponse($alias);
                //$response->send();
               // return new Response();
            }    
            
             $response->send();
                return new Response();
        }      
    }  
    
    public function invalidStore(Request $request) {
        
        
        if (\Drupal::currentUser()->isAnonymous()) {
            $response = new RedirectResponse('system.404');
            $response->send();
            return new Response();
        }
        
         $storeId = $request->get('id');
         return [
            '#theme' => 'storelogoutpage',
            '#storedata' => $storeId,
        ];
       
    }
}
