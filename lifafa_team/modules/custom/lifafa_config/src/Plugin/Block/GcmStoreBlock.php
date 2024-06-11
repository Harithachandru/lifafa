<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'GcmStoreBlock' block.
 *
 * @Block(
 *  id = "gcm_store_block",
 *  admin_label = @Translation("GCM Store block"),
 * )
 */
class GcmStoreBlock extends BlockBase
{
	/**
	 * {@inheritdoc}
	 */
	public function build()
	{
		global $base_url;

		$request = \Drupal::request();
		$current_path = $request->getPathInfo();
		$path_args = explode('/', $current_path);
		$mall = $path_args[1];
		if ($mall != 'store') {
			$storeID = $path_args[1];
		} else {
			$storeID = $path_args[2];
		}

		$store_url = \Drupal::config('lifafa_config.lifafaconfig')->get('store_url');
		$query = \Drupal::entityQuery('node')
			->condition('status', 1) //published or not
			->condition('type', 'gcm_store'); //content type

		$nids = $query->execute();
		$node_storage = \Drupal::entityTypeManager()->getStorage('node');
		$nodes = $node_storage->loadMultiple($nids);

		$data = [];
		$currentStore = getStoreIdFromSession();

		if (\Drupal::currentUser()->isAnonymous()) {
			$node = \Drupal::routeMatch()->getParameter('node');
			$currentStore = $node->field_store_id->value;
			$gcm = $node->field_store_type->value;
			$viewall = $node->field_gcm_viewall->value;
		} else {
			$nodes2 = \Drupal::entityTypeManager()
				->getStorage('node')
				->loadByProperties(['field_store_id' => $storeID, 'status' => 1]);

			if (empty($nodes2)) {
				$nodes2 = \Drupal::entityTypeManager()
					->getStorage('node')
					->loadByProperties(['field_store_id' => $currentStore, 'status' => 1]);
			}

			if (!empty($nodes2) && ($node2 = reset($nodes2))) {
				$gcm = $node2->field_store_type->value;
				$viewall = $node2->field_gcm_viewall->value;
			}
		}

		foreach ($nodes as $node) {
			$category = $node->field_category->target_id;
			$term = \Drupal::entityTypeManager()
				->getStorage('taxonomy_term')
				->load($category);
			$categoryTitle = $term->name->value;
			$categoryUrl = $term->field_store_category_url->value;
			$nid = $node->id();

			$store_disocunt_type = $node->field_store_disocunt_type->getValue();
			if (!empty($store_disocunt_type)) {

				$data[$category]['data'][$nid]['field_store'] = '';
				foreach ($store_disocunt_type as $element_block) {
					$pblock = \Drupal\paragraphs\Entity\Paragraph::load($element_block['target_id']);
					$store_nid = $pblock->field_store->target_id;
					$brandNode = Node::load($store_nid);
					if ($currentStore == $brandNode->field_store_id->value) {
						$discount = $pblock->field_discount->value;
						$discountType = $pblock->field_discount_type->value;
						$offer = $pblock->field_special_offer->value;
						$data[$category]['data'][$nid]['field_discount'] = $discount;
						$data[$category]['data'][$nid]['field_special_offer'] = $offer;
						$data[$category]['data'][$nid]['field_discount_type'] = $discountType;
						$store_node = \Drupal\node\Entity\Node::load($store_nid);
						$data[$category]['data'][$nid]['field_store'] = $store_node->field_store_id->value;
						if (!empty($pblock->field_discount_type->value)) {
							$discountType = $pblock->field_discount_type->value;
						}
					} else {
						continue;
					}
				}
				if (!empty($data[$category]['data'][$nid]['field_store'])) {
					$data[$category]['category_title'] = $categoryTitle;
					$data[$category]['category_url'] = $categoryUrl;
					$data[$category]['data'][$nid]['title'] = $node->title->value;
					$data[$category]['data'][$nid]['field_external_url'] = $node->field_external_url->value;
					$file = \Drupal\file\Entity\File::load($node->field_image->target_id);
					$path = $file->getFileUri();
					$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();
					$data[$category]['data'][$nid]['field_image'] = $url;
				}
			} else {
				continue;
			}
		}

		$build = [];
		$build['#theme'] = 'gcm_store_block';
		$build['default_block']['#markup'] = 'Implement DefaultBlock.';
		$build['#content'] = $data;
		$build['#gcm_type'] = $gcm;
		$build['#gcm_viewall'] = $viewall;
		$build['#discount_url'] = $discountType;
		$build['#store_landing_url'] = $store_url . $currentStore;
		$build['#current_store_id'] = $currentStore;

		$build['#markup'] = 'Implement DefaultBlock.';
		return $build;
	}

	public function getCommentData($nodeId)
	{
		$node = Node::load($nodeId);

		$data['node_title'] = $node->title->value;
		$data['sub_title'] = $node->field_sub_title->value;
		$data['node_id'] = $nodeId;

		$banner_id = $node->field_banner->target_id;

		if (!empty($banner_id)) {
			$node_banner_url = getFileUrl($banner_id);
		}

		$data['node_banner'] = $node_banner_url;

		$node_tiles_image_id = $node->field_tiles_image->target_id;
		if (!empty($node_tiles_image_id)) {
			$node_tiles_image_url = getFileUrl($node_tiles_image_id);
		}
		$data['tiles_image'] = $node_tiles_image_url;
		$data['vendor_id'] = $node->field_vendor_list_id->value;
		$tid = $node->field_category->target_id;

		$term = \Drupal::entityTypeManager()
			->getStorage('taxonomy_term')
			->load($tid);

		$title = $term->name->value;
		$sub_title = $term->field_sub_title->value;
		$category_image_id = $term->field_category_image->target_id;

		if (!empty($category_image_id)) {
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
			$comment = \Drupal\comment\Entity\Comment::load($cid);
			$comments[] = [
				'cid' => $cid,
				'uid' => $comment->getOwnerId(),
				'subject' => $comment->get('subject')->value,
				'body' => $comment->get('comment_body')->value,
				'rating' => $comment->get('field_rating')->value,
				'created' => $comment->get('created')->value,
			];
			$rating = $comment->get('field_rating')->value;
			$rating_count[] = $rating;
			$total_rating = $total_rating + $comment->get('field_rating')->value;
		}

		$rating_detail = array_count_values($rating_count);
		$total_comment = count($comments);
		$data['rating_detail'] = $rating_detail;
		$data['total_comment'] = $total_comment;
		$data['rating'] = $rating;
		$data['total_rating'] = $total_rating;
		$data['avg_rating'] = ceil($total_rating / $total_comment);
		return $data;
	}
}
