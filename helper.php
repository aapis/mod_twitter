<?php
/**
 * @subpackage	mod_twitter
 * @license		WTFPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.model');

abstract class modTwitterHelper{
	/**
	 * [getList Get the data from Twitter]
	 * @param  object $params The module parameters object
	 * @return object
	 */
	public static function getList($params){
		switch($params->get('type')){
			case 'hashtag':
				return modTwitterHelper::byHashTag($params);
			break;

			default: 
				return modTwitterHelper::byUsername($params);
		}
	}

	/**
	 * [byUsername Pull data from Twitter by the username]
	 * @param  object $params The module parameters object
	 * @return object
	 */
	public static function byUsername($params){
		$url = sprintf('https://api.twitter.com/1/statuses/user_timeline.json?screen_name=%s&count=%d', $params->get('screen_name'), $params->get('count'));
		$rawdata = file_get_contents($url);
		$data = array();

		if(false === empty($rawdata) && false !== $rawdata){
			$data = $rawdata;
		}else {
			$data[0] = new stdClass;
			$data[0]->Message = sprintf('There are no recent tweets for the user <strong>%s</strong> or there was an error contacting the server.', $params->get('screen_name'));
			$data[0]->Status = 'Error';
		}

		return (is_string($data) ? json_decode($data) : $data);
	}
	/**
	 * [byHashTag Pull data from Twitter by a hash tag]
	 * @param  object $params The module parameters object
	 * @return object
	 */
	public static function byHashTag($params){
		$url = sprintf('https://http://search.twitter.com/search.json?q=%s&rpp=%d', $hashtags, $params->get('count'));
		$rawdata = file_get_contents($url);
		$data = array();

		if(false === empty($rawdata) && false !== $rawdata){
			$data = $rawdata;
		}else {
			$data[0] = new stdClass;
			$data[0]->Message = sprintf('There are no recent tweets for the user <strong>%s</strong> or there was an error contacting the server.', $params->get('screen_name'));
			$data[0]->Status = 'Error';
		}

		return (is_string($data) ? json_decode($data) : $data);
	}
}
