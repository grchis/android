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
$uid =& JRequest::getVar( 'uid', '', 'get', 'string' );
$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=alerte&action=dealer&uid='.$uid;


$alerta =& JRequest::getVar( 'alerta', '', 'post', 'string' );
//verific daca avem alerta adaugata
$query = "SELECT count(*) FROM #__sa_zalerte WHERE `uid` = '".$uid."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
	//adaugam
	$query = "INSERT INTO #__sa_zalerte (`uid`, `alert_id`) VALUES ('".$uid."', '".$alerta."')";
} else {
	//editam
	$query = "UPDATE #__sa_zalerte SET `alert_id` = '".$alerta."' WHERE `uid` = '".$uid."'";
}
$db->setQuery($query);
$db->query();
$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_SET_ZALERT'));
