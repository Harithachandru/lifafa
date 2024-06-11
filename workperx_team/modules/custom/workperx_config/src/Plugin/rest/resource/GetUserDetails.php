<?php

namespace Drupal\workperx_config\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Cache\CacheableMetadata;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "get_user_data",
 *   label = @Translation("Get User Data"),
 *   uri_paths = {
 *     "canonical" = "/get-user-data"
 *   }
 * )
 */
class GetUserDetails extends ResourceBase {

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

        \Drupal::service('page_cache_kill_switch')->trigger();

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Credentials: true');

    // You must to implement the logic of your REST Resource here.
    // Use current user after pass authentication to validate access.
    if (!$this->currentUser->hasPermission('access content')) {
        throw new AccessDeniedHttpException();
    }
    
    
    $request = \Drupal::request();
    $is_logged = 0;
    $is_logged = $request->query->get('is_logged');

    // setcookie('is_logged', $is_logged, time() + 86400 * 30, "/");
    // if(isset($_COOKIE["is_logged"])) {
    //     $cookie = "Set";
    //     // The cookie is set, do something here
    // } else {
    //     // The cookie is not set, do something else here
    //     $cookie = "Not Set";
    // }

    $data['is_logged']  = $is_logged;
       
    

     // Create a new cookie instance
     $cookie = new Cookie('is_logged', $is_logged, time() + 86400, '/', '.workperx.local', false, true);

     // Create the response object
     $response = new ResourceResponse('Cookie set successfully', 200);
     $response->headers->setCookie($cookie);
 
     // Set the cache metadata
     $cache_metadata = (new CacheableMetadata())->addCacheContexts(['url.query_args:is_logged']);
     $response->addCacheableDependency($cache_metadata); 

    return $response;
//        return new ResourceResponse($payload, 200);
    }


}