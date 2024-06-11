<?php

namespace Drupal\lifafa_user\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\node\Entity\Node;

/**
 * Provides a 'UserInfoBlock' block.
 *
 * @Block(
 *  id = "user_info_block",
 *  admin_label = @Translation("User Info Block"),
 * )
 */
class UserInfoBlock extends BlockBase
{
	/**
	 * {@inheritdoc}
	 */
	public function build()
	{
		global $base_url;

		$build = [];
		$build['#theme'] = 'user_info_block';
		$build['default_block']['#markup'] = 'Implement DefaultBlock.';
		$build['#content'] = "";
		$build['#title'] = "";
		$build['#subtitle'] = "";
		$build['#user_content'] = "";
		$build['#markup'] = 'Implement DefaultBlock.';
		return $build;
	}
}