<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$db = JFactory::getDbo();
$uid =& JRequest::getVar( 'uid', '', 'post', 'string' );

	$query = "UPDATE #__users SET `block` = '0' WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$db->query();

	$query = "UPDATE #__sa_profiles SET `deleted` = '0' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query();

$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=profil&id='.$uid;
$app->redirect($link_redirect, 'Utilizatorul a fost restaurat cu succes');
?>