<?php

namespace Drupal\lifafa_config\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Psr\Log\LoggerInterface;

/**
 * Provides a resource to get view modes by entity and bundle.
 *
 * @RestResource(
 *   id = "create_store",
 *   label = @Translation("Create store"),
 *   uri_paths = {
 *     "create" = "/create-store"
 *   }
 * )
 */
class CreateStore extends ResourceBase {

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
    $instance->logger = $container->get('logger.factory')->get('lifafa_config');
    $instance->currentUser = $container->get('current_user');
    return $instance;
  }

    /**
     * Responds to POST requests.
     *
     * @param string $payload
     *
     * @return \Drupal\rest\ModifiedResourceResponse
     *   The HTTP response object.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *   Throws exception expected.
     */
    public function post($payload) {

        // You must to implement the logic of your REST Resource here.
        // Use current user after pass authentication to validate access.
        if (!$this->currentUser->hasPermission('access content')) {
            throw new AccessDeniedHttpException();
        }
              
        try{          
            $nodes = \Drupal::entityTypeManager()
            ->getStorage('node')
            ->loadByProperties(['field_store_id' => $payload['store_id']]);            
            if(empty($nodes)){
            $node = Node::create(
                [
                    'type' => 'customer_store',
                    'title' => $payload['store_name'],
                    'field_store_id' => $payload['store_id'],
                    'field_store_name' => $payload['store_name']
                ]
            );

            $node->enforceIsNew();
            $node->save();
            $this->logger->notice($this->t("Store with store nid @nid saved!\n", ['@nid' => $node->id()]));
            $nodes[] = $node->id();
                $message = $this->t("New Store Created with Store Id : @message", ['@message' => $payload['store_id']]);  
            }else{
                $message = $this->t("Store Already Exist with store Id : @message", ['@message' => $payload['store_id']]);      
            }
           return new ResourceResponse($message, 200);           
        } catch (Exception $ex) {
            $message = $this->t("Something went wrong with this store : @message", ['@message' => $payload['store_id']]);      
            return new ResourceResponse($message, 500);
        }                    
    }

}
