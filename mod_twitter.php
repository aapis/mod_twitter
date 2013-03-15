<?php
/**
 * @subpackage	mod_twitter
 * @license		WTFPL
 */

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$list = modTwitterHelper::getList($params);

$view = $params->get('display_type', 'default');

if(strpos($view, 'default') === FALSE){
	$view = 'default_'. $view;	
}

require JModuleHelper::getLayoutPath('mod_twitter', $view);
