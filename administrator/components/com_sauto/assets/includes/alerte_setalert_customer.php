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
$link_ok = 'index.php?option=com_sauto&task=alerte&action=customer&uid='.$uid;
		//echo 'acu setez alerta....<br />';
		$old_value =& JRequest::getVar( 'old_value', '', 'post', 'string' );
		$new_value =& JRequest::getVar( 'new_value', '', 'post', 'string' );
		//echo ' veche > '.$old_value.'<br /> noua > '.$new_value.'<br />';
		//obtin stringul din profil
		$query = "SELECT `alerte` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$alerte = $db->loadResult();
		//echo 'lista alerte: '.$alerte.'<br />';
		$alertele_noi = str_replace($old_value, $new_value, $alerte);
		//echo 'noile alerte > '.$alertele_noi;
		//actualizam profilul
		$query = "UPDATE #__sa_profiles SET `alerte` = '".$alertele_noi."' WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$db->query();
		$app->redirect($link_ok, JText::_('SAUTO_ALERT_SET_SUCCESS'));

	?> 
