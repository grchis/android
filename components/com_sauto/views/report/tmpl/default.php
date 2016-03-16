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
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');


$user =& JFactory::getUser();
$uid = $user->id;

//obtin ip
$ip = $_SERVER['REMOTE_ADDR'];

//if ($uid == 0) {
	//vizitator
//	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
//} else {
	//preiau variabile
	$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
	$uid =& JRequest::getVar( 'uid', '', 'post', 'string' );
	$link_ok = JRoute::_('index.php?option=com_sauto&view=request_detail&id='.$id);
	$query = "UPDATE #__sa_anunturi SET `raportat` = '1' WHERE  `id` = '".$id."'";
	$db->setQuery($query);
	$db->query();
	$query = "INSERT INTO #__sa_reported (`anunt_id`, `uid`, `stare`, `data_rep`, `ip`) VALUES ('".$id."', '".$uid."', '0', '".$curentDate."', '".$ip."')";
	$db->setQuery($query);
	$db->query();
	$app->redirect($link_ok, JText::_('SAUTO_REPORTED_SUCCESSFULY'));
//}
	
		
?>

