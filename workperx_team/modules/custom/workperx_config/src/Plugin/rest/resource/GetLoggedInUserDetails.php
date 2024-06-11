<?php

namespace Drupal\workperx_config\Plugin\rest\resource;

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
 *     "canonical" = "/get-user-details"
 *   }
 * )
 */
class GetLoggedInUserDetails extends ResourceBase {

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
     * Responds to Get requests.
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

        $user = \Drupal::currentUser()->id();


        $response = new ResourceResponse($user,200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $cache_metadata = (new CacheableMetadata())->addCacheContexts(['url.query_args:is_logged']);
        $response->addCacheableDependency($cache_metadata);

    return $response;
    }




}