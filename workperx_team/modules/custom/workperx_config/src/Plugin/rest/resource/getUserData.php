<?php

/**
 * @file
 * Contains \Drupal\workperx_config\Plugin\rest\resource\getUserData.
 */


namespace Drupal\workperx_config\Plugin\rest\resource;

use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "get_user_data",
 *   label = @Translation("Get user data"),
 *   uri_paths = {
 *     "canonical" = "/store/user/{user_id}/details"
 *   }
 * )
 */
class getUserData extends ResourceBase {

  /**
   * A current user instance.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  
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

        
      $data  = 'abc';
      $response = new ResourceResponse($data,200);
      return $response;
    }

    /**
   * Returns the permissions callback for this resource.
   *
   * @return array
   *   The permissions callback array.
   */
  public function permissions() {
    return [
      'access content' => [
        'title' => $this->t('Access content'),
      ],
    ];
  }

}
