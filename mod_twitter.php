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

require JModuleHelper::getLayoutPath('mod_twitter', $params->get('layout', 'default'));
