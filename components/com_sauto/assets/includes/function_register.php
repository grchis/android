<?php
/**
 * @package    sauto
 * @subpackage Views
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');

function addUser($username, $rnames, $email, $password, $block) {
	/*
jimport('joomla.user.helper');
$salt   = JUserHelper::genRandomPassword(32);
$crypted  = JUserHelper::getCryptedPassword($password, $salt);
$cpassword = $crypted.':'.$salt; $data = array( "name"=>$name, "username"=>$username, "password"=>$password,
"password2"=>$password, "email"=>$email, "block"=>0, "groups"=>array("1","2") );
$user = new JUser;
if(!$user->bind($data)) { throw new Exception("Could not bind data. Error: " . $user->getError()); }
if (!$user->save()) { echo "<br>Could not save user $name - " . $user->getError(); }
return $user->id;
*/
$db = JFactory::getDbo();
jimport('joomla.user.helper');
$pass = JUserHelper::hashPassword($password);
		$time = time();
		$params = '{"admin_style":"","admin_language":"","language":"","editor":"","helpsite":"","timezone":""}';
		$registerDate = date('Y-m-d H:i:s', $time);
		$n_name = explode(" ", $rnames);
		$username = $n_name[0].$time;
		$query = "INSERT INTO #__users (`name`, `username`, `password`, `params`, `email`, `block`, `registerDate`) VALUES 
					('".$rnames."', '".$username."', '".$pass."', '".$params."', '".$email."', '".$block."', '".$registerDate."')";
		$db->setQuery($query);
		$db->query();
		$last_id = $db->insertid();
		$query = "INSERT INTO #__user_usergroup_map (`user_id`, `group_id`) VALUES ('".$last_id."', '2')";
		$db->setQuery($query);
		$db->query();
		return $last_id;
		}
