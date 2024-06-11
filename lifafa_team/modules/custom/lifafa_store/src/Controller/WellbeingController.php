<?php

namespace Drupal\lifafa_store\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
use Drupal\lifafa_store\Controller\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LifafaStoreController.
 */
class WellbeingController extends ControllerBase
{

	public function getStore(Request $request)
	{
		$requestUri = $request->getRequestUri();
		global $base_url;

		$storeUrl = $this->getStoreUrl($_SESSION['idToken']);
		$response = new RedirectResponse($storeUrl);
		$response->send();
		return new Response();
	}

	public function pageNotFound()
	{

		return [
			'#theme' => 'page_not_found',
			'#storedata' => $data,
		];
	}

	public function detailPage($id)
	{
		$route = \Drupal::routeMatch()
			->getCurrentRouteMatch()
			->getRouteObject();
		echo "<pre>";
		print_r($route);
		die();
		echo $id;
		die();
		$nodes = \Drupal::entityTypeManager()
			->getStorage('node')
			->loadByProperties(['nid' => $id, 'status' => 1, 'type' => 'marketplace']);
		if (!empty($nodes) && ($node = reset($nodes))) {
			$data['id'] = $node->id();
			$_SESSION['lifafa_store']['store_terminal_id'] = $node->id();

			$data['title'] = $node->title->value;
			$bannerId = $node->field_marketplace_image->target_id;

			if (!empty($bannerId)) {
				$file = \Drupal\file\Entity\File::load($bannerId);
				$path = $file->getFileUri();
				$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();
				$data['main_banner'] = $url;
			}
			$paragraph_blocks = $node->field_blocks_content->getValue();
			foreach ($paragraph_blocks as $element_block) {
				$pblock = \Drupal\paragraphs\Entity\Paragraph::load($element_block['target_id']);
				$data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;
				$data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
				$data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;
			}
			return [
				'#theme' => 'wellbeing_template',
				'#storedata' => $data,
			];
		} else {
			// return 404
			$response = new RedirectResponse('/system.404');
			$response->send();
			return new Response();
		}
	}

	/**
	 * @name getStoreTerminalID
	 * @desc this is parse session data into array
	 * @param type $token
	 * @return url
	 */
	protected function getStoreUrl($token = '')
	{
		global $base_url;
		try {

			$storeId = getStoreUrl();
			$tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
			//clear storage
			$tempstore->delete('userClaimperks');
			$storeId = $this->getStoreTerminalId($token);
			$tempstore->set('storeTerminalId', $storeId);
			$url = $base_url . '/store/' . $storeId . '/home';
			return $url;
		} catch (Exception $ex) {
			return $ex->getMessages();
		}
	}

	public function checkExtingToken($urlId = '')
	{
		// Return 404 Page If URL token does not match
		$response = new RedirectResponse($storeUrl);
		$response->send();
		if (empty($urlId)) {
			return new Response();
		}
		if ($urlId != $sessionId && \Drupal::currentUser()->isAuthenticated()) {
			// Redirect 404 Invalid pae
			return new Response();
		}
	}

	public static function getStoreData($storeId)
	{
		$data = [];
		if (empty($storeId)) {
			return;
		}

		$nodes = \Drupal::entityTypeManager()
			->getStorage('node')
			->loadByProperties(['field_store_id' => $storeId, 'status' => 1]);

		if ($node = reset($nodes)) {
			$data['id'] = $node->id();
			$_SESSION['lifafa_store']['store_terminal_id'] = $node->id();

			$data['title'] = $node->title->value;
			$data['store_id'] = $node->field_store_id->value;
			$data['store_name'] = $node->field_store_name->value;
			$logoId = $node->field_store_logo->target_id;
			$bannerId = $node->field_store_banner->target_id;

			$file = \Drupal\file\Entity\File::load($bannerId);
			$path = $file->getFileUri();
			$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();
			$data['store_banner'] = $url;

			$file = \Drupal\file\Entity\File::load($logoId);
			$path = $file->getFileUri();
			$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();
			$data['store_logo'] = $url;

			$paragraph = $node->field_store_slider->getValue();
			$data['store_slider'] = [];
			foreach ($paragraph as $element) {
				$p = \Drupal\paragraphs\Entity\Paragraph::load($element['target_id']);

				$data['store_slider'][$element['target_id']]['banner_heading'] = $p->field_banner_heading->value;

				$mainImagesId = $p->field_banner_image->target_id;
				$file = \Drupal\file\Entity\File::load($mainImagesId);
				$path = $file->getFileUri();
				$mainImageurl = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();

				$data['store_slider'][$element['target_id']]['banner_image'] = $mainImageurl;
				$data['store_slider'][$element['target_id']]['banner_subheading'] = $p->field_banner_subheading->value;
			}

			$paragraph_blocks = $node->field_pae_blocks->getValue();
			foreach ($paragraph_blocks as $element_block) {
				$pblock = \Drupal\paragraphs\Entity\Paragraph::load($element_block['target_id']);
				$data['store_blocks'][$element_block['target_id']]['block_subtitle'] = $pblock->field_block_subtitle->value;
				$data['store_blocks'][$element_block['target_id']]['block_title'] = $pblock->field_block_title->value;
				$data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;
			}
			return $data;
		}
	}

	public function getStoreTerminalId($idToken = '')
	{
		$tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');

		if (empty($idToken)) {
			return '';
		}

		$tokenArray = explode(".", $idToken);
		if (!isset($tokenArray[1])) {
			return null;
		}

		$parsedJwt = base64_decode($tokenArray[1]);

		if (!$parsedJwt) {
			return null;
		}

		$userDetailsArray = json_decode($parsedJwt, true);
		if (!$userDetailsArray) {
			return null;
		}

		if (isset($userDetailsArray['storeTerminalId'])) {
			$userdata['given_name'] = $userDetailsArray['given_name'];
			$userdata['family_name'] = $userDetailsArray['family_name'];
			$userdata['full_name'] = $userDetailsArray['name'];
			$userdata['email'] = $userDetailsArray['email'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$tempstore->set('userData', $userdata);
			return strtolower($userDetailsArray['storeTerminalId']);
		}

		return null;
	}

	public function getStoreTerminalLogo(Request $request)
	{
		$storeId = $request->get('id');
		$data = [];
		if (empty($storeId)) {
			return;
		}
		$nodes = \Drupal::entityTypeManager()
			->getStorage('node')
			->loadByProperties(['field_store_id' => $storeId, 'status' => 1]);
		if ($node = reset($nodes)) {
			$logoId = $node->field_store_logo->target_id;
			$file = \Drupal\file\Entity\File::load($logoId);
			if (!empty($file)) {
				$path = $file->getFileUri();
				$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => !empty(getenv('APP_ENV')) ? true : false])->toString();
				$data['store_logo'] = $url;
				header('Content-type: image/jpeg');
				echo file_get_contents($url);
				die();
			}
		}
	}

	public function sendPerksClaimEmail(Request $request)
	{
		$node_id = $request->get('nodeid');
		$node_title = $request->get('nodeTitle');
		$this->updateClaimedPerks($node_id);
		$this->SendEmailToLifafa($request);
		$this->SendEmailToCustomer($node_id, $node_title);
		$response['status'] = json_encode(["success"]);

		return new JsonResponse($response);
		return $text;
	}

	public function SendEmailToLifafa($request)
	{
		$userdata = getStoreUserData();
		$node_id = $request->get('nodeid');
		$node_title = $request->get('nodeTitle');
		$requesrUrl = $request->server->get('HTTP_REFERER');
		$given_name = $userdata["given_name"];
		$family_name = $userdata["family_name"];
		$name = $userdata["name"];
		$email = $userdata["email"];
		$userdata["given_name"];
		$company = $userdata["storeTerminalId"];

		$msg =
			"Hello Team
		
				Following will be picked up from system for Logged in User:
			
				User First Name: $given_name
					
				User last Name: $family_name
					
				User Company: $company
				
				User email id: $email
					
				User phone number: xxxxxxxxxx
				
				Perk Requested: $node_title
					
				Requested Date: " .
			date('Y-m-d H:i:s') .
			"
		
			Thanks!
			
			Team Lifafa";

		$mailManager = \Drupal::service('plugin.manager.mail');
		$module = 'lifafa_store';
		$key = 'lifafa_team_perk';
		$to = 'care@lifafa.com'; //\Drupal::currentUser()->getEmail();
		$params['message'] = $msg;
		$params['node_title'] = $node_title;
		$langcode = \Drupal::currentUser()->getPreferredLangcode();
		$send = true;

		$result = $mailManager->mail($module, $key, $to, $langcode, $params, null, $send);
		if ($result['result'] !== true) {
			drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
		} else {
			drupal_set_message(t('Your message has been sent.'));
		}
	}

	public function SendEmailToCustomer($id, $title)
	{
		$userdata = getStoreUserData();
		$name = $userdata["given_name"];
		$email = $userdata["email"];

		$msg = "Dear $name,

		Thanks for placing order for $title. 

		Your order will be processed within 24 hours.

		Thanks!
		Team Lifafa";

		$mailManager = \Drupal::service('plugin.manager.mail');
		$module = 'lifafa_store';
		$key = 'thanks_customer_perk';
		$to = $email; //\Drupal::currentUser()->getEmail();
		$params['message'] = $msg;
		$params['node_title'] = $title;
		$langcode = \Drupal::currentUser()->getPreferredLangcode();
		$send = true;

		$result = $mailManager->mail($module, $key, $to, $langcode, $params, null, $send);
		if ($result['result'] !== true) {
			drupal_set_message(t('There was a problem sending your message and it was not sent.'), 'error');
		} else {
			drupal_set_message(t('Your message has been sent.'));
		}
	}

	/**
	 *
	 * @param type $nodeId
	 */
	public function updateClaimedPerks($nodeId)
	{
		$tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
		$data = $tempstore->get('userClaimperks');

		if (!empty($data['claim_perks'])) {
			$data['claim_perks'][] = $nodeId;
		} else {
			$data['claim_perks'][] = $nodeId;
		}
		$data2['claim_perks'] = array_unique($data['claim_perks']);
		$tempstore->set('userClaimperks', $data2);
		return true;
	}

	public function requestBooking($id)
	{
		$my_webform_machinename = 'booking_request';
		$my_form = \Drupal::entityTypeManager()
			->getStorage('webform')
			->load($my_webform_machinename);

		$values = ['data' => ['vgtest' => 'Custom Name']];
		$my_form->getSubmissionForm($values);

		$output = \Drupal::entityTypeManager()
			->getViewBuilder('webform')
			->view($my_form);

		return $output;
	}

	public function requestInsurancePlan($id)
	{
		$my_webform_machinename = 'insurance_lead';
		$my_form = \Drupal::entityTypeManager()
			->getStorage('webform')
			->load($my_webform_machinename);

		$values = ['data' => ['vgtest' => 'Custom Name']];
		$my_form->getSubmissionForm($values);

		$output = \Drupal::entityTypeManager()
			->getViewBuilder('webform')
			->view($my_form);

		return $output;
	}
}
