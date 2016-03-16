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

	$query = "SELECT `email` FROM #__users WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$email = $db->loadResult();
	$n_email = $email.'.deleted';
	$query = "UPDATE #__users SET `email` = '".$n_email."', `block` = '1' WHERE `id` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
	
	//obtin telefonul
	$query = "SELECT `telefon` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$tel = $db->loadResult();
	$n_tel = $tel.'d';
	$query = "UPDATE #__sa_profiles SET `deleted` = '1', `telefon` = '".$n_tel."' WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$db->query();

$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=profil&id='.$uid;
$app->redirect($link_redirect, 'Utilizatorul a fost dezactivat cu succes');
?>