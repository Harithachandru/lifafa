<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'BannerBlock' block.
 *
 * @Block(
 *  id = "banner_block",
 *  admin_label = @Translation("Banner block"),
 * )
 */
class BannerBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
      
      
      
        $request = \Drupal::request();
        $current_path = $request->getPathInfo();
        $path_args = explode('/', $current_path);
        $first_argument = $path_args[3];
        
        $data = $this->getTermDataData($first_argument);
        //print_r($data);

    $build = [];
    $build['#theme'] = 'banner_block';
    $build['default_block']['#markup'] = 'Implement DefaultBlock.';
    $build['#content'] = $data;
    $build['#markup'] = 'Implement DefaultBlock.';
    return $build;
  }
  
  public function getTermDataData($tid){
      


        $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
        
        $title = $term->name->value;
        $sub_title = $term->field_sub_title->value;
        $category_image_id = $term->field_category_image->target_id;
        
        if(!empty($category_image_id)){
            $category_image_url = getFileUrl($category_image_id);
        }

        $data['category_name'] = $title;
        $data['category_subtitle'] = $sub_title;
        $data['category_banner'] = $category_image_url;


    return $data;

      
      $node = Node::load($nodeId);
      
     //dump($node);
      
      $data['node_title'] = $node->title->value;
      $data['sub_title'] = $node->field_sub_title->value;
      
      $banner_id = $node->field_banner->target_id;
      
      if(!empty($banner_id)){
            $node_banner_url = getFileUrl($banner_id);
       }
      
      
      $data['node_banner'] = $node_banner_url;
      
      return $data;
      
      $node_tiles_image_id = $node->field_tiles_image->target_id;
      if(!empty($node_tiles_image_id)){
            $node_tiles_image_url = getFileUrl($node_tiles_image_id);
        }
      $data['tiles_image'] = $node_tiles_image_url;
      $data['vendor_id'] = $node->field_vendor_list_id->value;
      $tid = $node->field_category->target_id;
      
        
        $term = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($tid);
        
        $title = $term->name->value;
        $sub_title = $term->field_sub_title->value;
        $category_image_id = $term->field_category_image->target_id;
        
        if(!empty($category_image_id)){
            $category_image_url = getFileUrl($category_image_id);
        }

        $data['category_name'] = $title;
        $data['category_subtitle'] = $sub_title;
        $data['category_banner'] = $category_image_url;        
      
      $entity_manager = \Drupal::entityTypeManager();
        $cids = $entity_manager
                ->getStorage('comment')
                ->getQuery('AND')
                ->condition('entity_id', $nodeId)
                ->condition('entity_type', 'node')                
                ->execute();

        $comments = [];
        $total_rating = 0;
        $rating_count;
        foreach ($cids as $cid) {
            //$comment = Comment::load($cid);
            $comment = \Drupal\comment\Entity\Comment::load($cid);
            $comments[] = [
                'cid' => $cid,
                'uid' => $comment->getOwnerId(),
                'subject' => $comment->get('subject')->value,
                'body' => $comment->get('comment_body')->value,
                'rating' => $comment->get('field_rating')->value,
                'created' => $comment->get('created')->value
            ];
            $rating = $comment->get('field_rating')->value;
            $rating_count[] = $rating;
            $total_rating = $total_rating + $comment->get('field_rating')->value;
        }

               
        
        $rating_detail = array_count_values($rating_count);
        $total_comment = count($comments);
        $data['rating_detail'] = $rating_detail;
        $data['total_comment']  = $total_comment;
        $data['rating'] = $rating;
        $data['total_rating'] = $total_rating;
        $data['avg_rating'] = ceil($total_rating/$total_comment);
        return $data;
        
        
    }
  

}
