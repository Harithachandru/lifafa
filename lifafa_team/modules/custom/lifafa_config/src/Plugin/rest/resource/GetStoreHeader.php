<?php

namespace Drupal\lifafa_config\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Cache\CacheableMetadata;


/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "get_store_header",
 *   label = @Translation("Get store header"),
 *   uri_paths = {
 *     "canonical" = "/get-store-header/{storeId}"
 *   }
 * )
 */
class GetStoreHeader extends ResourceBase {

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
        $request = \Drupal::request();
        $islogged = $request->query->get('is_logged');
        if($islogged=='true'){
            $data['store_header']  = getLoggedStoreHeader($payload);}
        else{
            $data['store_header']  = getStoreHeader($payload);
        }
        $data['store_fevicon']  = getfevicon($payload);
    $response = new ResourceResponse($data,200);
    $response->headers->set('Content-Type', 'text/plain');
    $cache_metadata = (new CacheableMetadata())->addCacheContexts(['url.query_args:is_logged']);
    $response->addCacheableDependency($cache_metadata); 

    // In order to generate fresh result every time (without clearing 
    // the cache), you need to invalidate the cache.
    //$response->addCacheableDependency($data);
    return $response;
//        return new ResourceResponse($payload, 200);
    }


}