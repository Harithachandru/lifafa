<?php

namespace Drupal\lifafa_store\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\Request;
//use Drupal\lifafa_store\Controller\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use Drupal\user\PrivateTempStoreFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LifafaStoreController.
 */
class LifafaStoreController extends ControllerBase
{
	/**
	 * Getstore.
	 *
	 * @return string
	 *   Return Hello string.
	 */
	//public function __construct(PrivateTempStoreFactory $temp_store_factory) {
	public function __construct(PrivateTempStoreFactory $temp_store_factory)
	{
		if (\Drupal::currentUser()->isAuthenticated()) {
			
			$tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
			$storeId = $this->getStoreTerminalId($_SESSION['idToken']);
			$companyId = $this->getCompanyTerminalId($_SESSION['idToken']);
			$name = $this->getUserName($_SESSION['idToken']);
			$code = $this->getCompanyCode($_SESSION['idToken']);
			$userId = $this->getUserId($_SESSION['idToken']);
			$token = $this->getAccessToken($_SESSION['idToken']);

			//$storeId = $this->getStoreTerminalId(1235);
			$tempstore->set('storeTerminalId', $storeId);
			$tempstore->set('userName', $name);
			$tempstore->set('companyCode', $code);
			$tempstore->set('companyTerminalId', $companyId);
			$tempstore->set('userid', $userId);
			$tempstore->set('JwtToken', $token);

			setcookie('storeid', $storeId, time() + 86400 * 30, "/"); // 86400 = 1 day
		}

		if (\Drupal::currentUser()->isAnonymous()) {
			// Anonymous user...
		}
	}

	public static function create(ContainerInterface $container)
	{
		return new static($container->get('user.private_tempstore'));
	}

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
		//$storeId = $request->get('id');

		return [
			'#theme' => 'page_not_found',
			'#storedata' => $data,
		];
	}

	public function storeHomePage(Request $request)
	{
		$storeId = $request->get('id');
		$data = $this->getStoreData($storeId);
		$storeSessionId = getStoreIdFromSession();
		if ($storeSessionId != $storeId) {
			$response = new RedirectResponse('system.404');
			$response->send();
			return new Response();
		}

		return [
			'#theme' => 'storepage',
			'#storedata' => $data,
		];
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

		if (!empty($nodes) && ($node = reset($nodes))) {
			$data['id'] = $node->id();

			$_SESSION['lifafa_store']['store_terminal_id'] = $node->id();

			$data['title'] = $node->title->value;
			$data['store_id'] = $node->field_store_id->value;

			$logoId = $node->field_store_logo->target_id;

			$bannerId = $node->field_store_banner->target_id;
			$templatetype = $node->field_template_type->value;
			$data['template_type'] = $templatetype;

			$file = \Drupal\file\Entity\File::load($bannerId);
			$path = $file->getFileUri();
			$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
				!empty(getenv('APP_ENV')) ? true : false
			])->toString();
			$data['store_banner'] = $url;

			$file = \Drupal\file\Entity\File::load($logoId);
			$path = $file->getFileUri();
			$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
				!empty(getenv('APP_ENV')) ? true : false
			])->toString();
			
			$data['store_logo'] = $url;

			$paragraph = $node->field_store_slider->getValue();
			$data['store_slider'] = [];
			foreach ($paragraph as $element) {
				$p = \Drupal\paragraphs\Entity\Paragraph::load($element['target_id']);

				$data['store_slider'][$element['target_id']]['banner_heading'] = $p->field_banner_heading->value;

				$mainImagesId = $p->field_banner_image->target_id;
				$file = \Drupal\file\Entity\File::load($mainImagesId);
				$path = $file->getFileUri();
				$mainImageurl = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
					!empty(getenv('APP_ENV')) ? true : false
				])->toString();

				$data['store_slider'][$element['target_id']]['banner_image'] = $mainImageurl;
				$data['store_slider'][$element['target_id']]['banner_subheading'] = $p->field_banner_subheading->value;
				$data['store_slider'][$element['target_id']]['banner_url'] = $p->field_banner_url->value;
			}

			$paragraph_blocks = $node->field_pae_blocks->getValue();

			foreach ($paragraph_blocks as $element_block) {
				$pblock = \Drupal\paragraphs\Entity\Paragraph::load($element_block['target_id']);

				$tempstore = \Drupal::service('user.private_tempstore')->get('lifafa_store');
				$user_name = $tempstore->get('userName');

				$title = $pblock->field_block_title->value;
				$block_subtitle = $pblock->field_block_subtitle->value;
				$template = $pblock->field_template->value;
				$block_content = $pblock->field_block_footer_text->value;

				# Get user points only for user info block
				if($pblock->field_stores->plugin_id == "user_info_block") {
					$company_code = '';
					if (\Drupal::currentUser()->isAuthenticated()) {
						$idToken = $_SESSION['idToken'];
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
						$company_code = isset($userDetailsArray['companyCode']) ? $userDetailsArray['companyCode'] : "";
						
						if (isset($userDetailsArray['rewardTier'])) {
							if ($userDetailsArray['rewardTier'] == "Others") {
								$dealerClub = "";
							} else {
								$dealerClub = $userDetailsArray['rewardTier'];
							}
						}
						
						$companyName = $userDetailsArray['companyName'];
						$rewardTierIcon = isset($userDetailsArray['rewardTierIcon']) ? $userDetailsArray['rewardTierIcon'] : "";
					}

					$data['rewardTierIcon'] = $rewardTierIcon;
					$code = explode("-", $company_code)[0];
					$dealerCode = (string) $code;

					$user = getCurrentPoints();
					
					$available_points = $user['data'][0]->availablePoints;
					$points = (string) $available_points;

					$title = str_replace('#name#', $user_name, $title);
					$title = str_replace('#current_points#', $points, $title);
					$title = str_replace('#company_code#', $dealerCode, $title);
					$title = str_replace('#tier_type#', $dealerClub, $title);
					$title = str_replace('#store_name#', $companyName, $title);

					$subtitle = str_replace('#name#', $user_name, $block_subtitle);
					$subtitle = str_replace('#current_points#', $points, $subtitle);
					$subtitle = str_replace('#company_code#', $dealerCode, $subtitle);
					$subtitle = str_replace('#tier_type#', $dealerClub, $subtitle);
					$subtitle = str_replace('#store_name#', $companyName, $subtitle);
					$block_subtitle = nl2br($subtitle, true);

					$content = str_replace('#name#', $user_name, $block_content);
					$content = str_replace('#current_points#', $points, $content);
					$content = str_replace('#company_code#', $dealerCode, $content);
					$content = str_replace('#tier_type#', $dealerClub, $content);
					$content = str_replace('#store_name#', $companyName, $content);

					$block_content = nl2br($content, true);
				}

				$delimiter = '<br />';
				$words = explode($delimiter, $block_subtitle);
				foreach ($words as $word) {
					$data['store_blocks'][$element_block['target_id']]['block_subtitle'][] = $word;
				}

				$delimiter = '<br />';
				$lines = explode($delimiter, $block_content);
				foreach ($lines as $line) {
					$data['store_blocks'][$element_block['target_id']]['block_footer'][] = $line;
				}
				
				$data['store_blocks'][$element_block['target_id']]['template'] = $template;
				$data['store_blocks'][$element_block['target_id']]['block_title'] = $title;

				if (isset($dealerClub)) {
					if ($dealerClub == "") {
						$data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;
						return $data;
					} else {
						$data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;
					}
				} else {
					$data['store_blocks'][$element_block['target_id']]['block_stores'] = $pblock->field_stores->plugin_id;
				}
			}

			return $data;
		}
	}
	public function getAccessToken($token = '')
	{
		if (empty($token)) {
			return '';
		}
		return $token;
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
			$userdata['company_name'] = $userDetailsArray['companyName'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$tempstore->set('userData', $userdata);
			return strtolower($userDetailsArray['storeTerminalId']);
		}

		return null;
	}

	public function getCompanyTerminalId($idToken = '')
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

		if (isset($userDetailsArray['companyTerminalId'])) {
			$userdata['given_name'] = $userDetailsArray['given_name'];
			$userdata['family_name'] = $userDetailsArray['family_name'];
			$userdata['full_name'] = $userDetailsArray['name'];
			$userdata['email'] = $userDetailsArray['email'];
			$userdata['companyId'] = $userDetailsArray['companyTerminalId'];
			$userdata['company_name'] = $userDetailsArray['companyName'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$userdata['userId'] = $userDetailsArray['preferred_username'];
			$tempstore->set('userData', $userdata);
			return $userDetailsArray['companyTerminalId'];
		}

		return null;
	}

	public function getUserName($idToken = '')
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

		if (isset($userDetailsArray['name'])) {
			$userdata['given_name'] = $userDetailsArray['given_name'];
			$userdata['family_name'] = $userDetailsArray['family_name'];
			$userdata['full_name'] = $userDetailsArray['name'];
			$userdata['email'] = $userDetailsArray['email'];
			$userdata['companyId'] = $userDetailsArray['companyTerminalId'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$userdata['company_name'] = $userDetailsArray['companyName'];
			$userdata['userId'] = $userDetailsArray['preferred_username'];
			$tempstore->set('userData', $userdata);
			return $userDetailsArray['name'];
		}

		return null;
	}

	public function getUserId($idToken = '')
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

		if (isset($userDetailsArray['preferred_username'])) {
			$userdata['given_name'] = $userDetailsArray['given_name'];
			$userdata['family_name'] = $userDetailsArray['family_name'];
			$userdata['full_name'] = $userDetailsArray['name'];
			$userdata['email'] = $userDetailsArray['email'];
			$userdata['companyId'] = $userDetailsArray['companyTerminalId'];
			$userdata['company_name'] = $userDetailsArray['companyName'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$userdata['userId'] = $userDetailsArray['preferred_username'];
			$tempstore->set('userData', $userdata);
			return strtoupper($userDetailsArray['preferred_username']);
		}

		return null;
	}
	public function getCompanyCode($idToken = '')
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

		if (isset($userDetailsArray['companyCode'])) {
			$userdata['given_name'] = $userDetailsArray['given_name'];
			$userdata['family_name'] = $userDetailsArray['family_name'];
			$userdata['full_name'] = $userDetailsArray['name'];
			$userdata['email'] = $userDetailsArray['email'];
			$userdata['companyId'] = $userDetailsArray['companyTerminalId'];
			$userdata['company_name'] = $userDetailsArray['companyName'];
			$userdata['storeTerminalId'] = strtolower($userDetailsArray['storeTerminalId']);
			$userdata['userId'] = $userDetailsArray['preferred_username'];
			$tempstore->set('userData', $userdata);
			return $userDetailsArray['companyCode'];
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
				$url = \Drupal\Core\Url::fromUri(file_create_url($path), ['https' => 
					!empty(getenv('APP_ENV')) ? true : false
				])->toString();
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
		$to = 'care@lifafa.com'; 
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

		$body_data = [
			'#theme' => 'sendCustomerEmail',
			'#given_name' => "{$name}",
			'#title' => "{$title}",
			'#dynamic_key2' => "{test ji}",
		];

		$msg = \Drupal::service('renderer')->render($body_data);

		$mailManager = \Drupal::service('plugin.manager.mail');
		$module = 'lifafa_store';
		$key = 'thanks_customer_perk';
		$to = $email;
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

	/**
	 * Set Store Logout
	 */
	public function setStoreLogout()
	{
		try {
			if (isset($_COOKIE['storeid'])) {
				$storeId = $_COOKIE['storeid'];
				$nodes = \Drupal::entityTypeManager()
					->getStorage('node')
					->loadByProperties(['field_store_id' => $storeId, 'status' => 1]);
				if ($node = reset($nodes)) {
					$nid = $node->ID();
					$alias = \Drupal::service('path.alias_manager')->getAliasByPath('/node/' . $nid);
					unset($_COOKIE['storeid']);
					setcookie('storeid', '', time() + 86400 * 30, "/");
					$response = new RedirectResponse($alias);
				}

				$response->send();
				return new Response();
			} else {
				throw new \Exception("No Store Id is set in the cookie");
			}
		} catch (\Throwable $th) {
			global $base_url;

			if (isset($_COOKIE['query_param'])) {
				
				$storeIdArray = explode("=", $_COOKIE['query_param']);

				if (is_array($storeIdArray) && isset($storeIdArray[1])) {
					$exceptionStoreId = $storeIdArray[1];
					$response = new RedirectResponse($base_url . "/" . $exceptionStoreId . "/home");
					$response->send();
					return;
				} else {
					// redirect to lifafa.com
					$response = new RedirectResponse($base_url);
					$response->send();
					return;
				}
			} else {
				// redirect to lifafa.com
				$response = new RedirectResponse($base_url);
				$response->send();
				return;
			}
		}
	}

	public function invalidStore(Request $request)
	{
		if (\Drupal::currentUser()->isAnonymous()) {
			$response = new RedirectResponse('system.404');
			$response->send();
			return new Response();
		}

		$storeId = $request->get('id');
		return [
			'#theme' => 'storelogoutpage',
			'#storedata' => $storeId,
		];
	}
}
