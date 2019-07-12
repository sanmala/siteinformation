<?php
/**
 * @file
 * Contains \Drupal\siteinformation\Controller\JsonController.
 */
namespace Drupal\siteinformation\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Implementing our example JSON api.
 */
class JsonController extends ControllerBase {

  /**
   * Callback for the API.
   */
  public function renderApi($custom_site_key = NULL, $nid = NULL) {
	
	$node_info 	= \Drupal\node\Entity\Node::load($nid);	
	$apiKey 	= (\Drupal::config('system.site')->get('siteapikey') == $custom_site_key)?true:false;	
	$serializer = \Drupal::service('serializer');
	
	if($apiKey == true && !empty($node_info) && $node_info->bundle() == 'page') {
		$json = $serializer->serialize($node_info, 'json');
		
		return new JsonResponse([
		  'data' => json_decode($json),
		  'method' => 'GET',
		], 200);
	} else {
		return new JsonResponse([
		  'data' => 'access denied',
		  'method' => 'GET',
		], 403);
	}
  }

}
