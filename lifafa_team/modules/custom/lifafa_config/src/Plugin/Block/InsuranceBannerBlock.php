<?php

namespace Drupal\lifafa_config\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'InsuranceBannerBlock' block.
 *
 * @Block(
 *  id = "insurance_banner_block",
 *  admin_label = @Translation("Insurance Banner block"),
 * )
 */
class InsuranceBannerBlock extends BlockBase
{
	/**
	 * {@inheritdoc}
	 */
	public function build()
	{
		$build = [];

		$request = \Drupal::request();
		$current_path = $request->getPathInfo();
		$path_args = explode('/', $current_path);
		$first_argument = $path_args[4];
		if (!empty($first_argument)) {
			$data = $this->getTermDataData($first_argument);
			$build = [];
			$build['#theme'] = 'insurance_banner_block';
			$build['default_block']['#markup'] = 'Implement DefaultBlock.';
			$build['#content'] = $data;
			$build['#markup'] = 'Implement DefaultBlock.';
			$build['#cache'] = ['max-age' => 0];
		}
		return $build;
	}

	public function getTermDataData($tid)
	{
		$term = \Drupal::entityTypeManager()
			->getStorage('taxonomy_term')
			->load($tid);

		$title = $term->name->value;
		$sub_title = isset($term->field_sub_title->value) ? $term->field_sub_title->value : "";
		$category_image_id = $term->field_banner->target_id;
		if (!empty($category_image_id)) {
			$category_image_url = getFileUrl($category_image_id);
		}
		$data['category_name'] = $title;
		$data['category_subtitle'] = $sub_title;
		$data['category_banner'] = $category_image_url;
		return $data;
	}
}
