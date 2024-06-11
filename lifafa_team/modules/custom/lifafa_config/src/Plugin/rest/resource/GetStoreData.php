<?php

namespace Drupal\lifafa_config\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "get_store_data",
 *   label = @Translation("Get store data"),
 *   uri_paths = {
 *     "canonical" = "/get-store-data/{storeId}"
 *   }
 * )
 */
class GetStoreData extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
    $instance->logger = $container->get('logger.factory')->get('lifafaconfig');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

    /**
     * Responds to GET requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function get($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
        
        if(empty($payload)){
            return ;
        }

        $data  = $this->getStoreLogo($payload);

    $response = new ResourceResponse($data,200);
    // In order to generate fresh result every time (without clearing 
    // the cache), you need to invalidate the cache.
    //$response->addCacheableDependency($data);
    return $response;
//        return new ResourceResponse($payload, 200);
    }

    /**
     *
     * @return type
     */
    private function getStoreLogo($storeId){
            $data['store_fevicon']='';
            $data['store_logo']='';
            if(empty($storeId)){return ; }
            $nodes = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_store_id' => $storeId,'status'=>1]);
            if ($node = reset($nodes)) {
                $logoId = $node->field_store_logo->target_id;
                $feviconId = $node->field_store_fevicon->target_id;
                
                $file = \Drupal\file\Entity\File::load($logoId);                
                if(!empty($file)){
                    $path = $file->getFileUri();
                    $url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
					!empty(getenv('APP_ENV')) ? true : false
				])->toString();
                    $data['store_logo']=$url;                                        
                }
                                
                if(!empty($feviconId)){
                    $fevicon = \Drupal\file\Entity\File::load($feviconId);
                    $path2 = $fevicon->getFileUri();
                    $url2 = \Drupal\Core\Url::fromUri(file_create_url($path2), ['https' => 
					!empty(getenv('APP_ENV')) ? true : false
				])->toString();
                    $data['store_fevicon']=$url2;
                }                
            }
            return $data;
    }

}
