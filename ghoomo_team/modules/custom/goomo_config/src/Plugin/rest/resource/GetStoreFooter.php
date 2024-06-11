<?php

namespace Drupal\goomo_config\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Drupal\Core\Cache\CacheableMetadata;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "get_store_footer",
 *   label = @Translation("Get store footer"),
 *   uri_paths = {
 *     "canonical" = "/get-store-footer/{storeId}"
 *   }
 * )
 */
class GetStoreFooter extends ResourceBase
{

    /**
     * A current user instance.
     *
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $currentUser;

    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);
        $instance->logger = $container->get('logger.factory')->get('lifafaconfig');
        $instance->currentUser = $container->get('current_user');
        return $instance;
    }

    /**
     * Responds to GET requests.
     *
     * @param string $storeId
     *
     * @return \Drupal\rest\ResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function get($storeId)
    {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }

        if (empty($storeId)) {
            return;
        }

        $request = \Drupal::request();
        $islogged = $request->query->get('is_logged');
        if ($islogged == 'true')
            $data['store_footer']  = getLoggedStoreFooter($storeId);
        else
            $data['store_footer']  = getStoreFooter($storeId);

        // $data['store_footer']  = getStoreFooter($storeId);

        $response = new ResourceResponse($data, 200);
        $response->headers->set('Content-Type', 'text/plain');

        // In order to generate fresh result every time (without clearing 
        // the cache), you need to invalidate the cache.
        //$response->addCacheableDependency($data);
        $cache_metadata = (new CacheableMetadata())->addCacheContexts(['url.query_args:is_logged']);
        $response->addCacheableDependency($cache_metadata);
        return $response;
        //        return new ResourceResponse($storeId, 200);
    }
}
