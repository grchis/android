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
$db = JFactory::getDbo();
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto');


$user =& JFactory::getUser();
$uid = $user->id;

if ($uid == 0) {
	//vizitator
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
	$anunt_id =& JRequest::getVar( 'id', '', 'get', 'string' );
	//preiau variabile
	$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
	$db->setQuery($query);
	$tip = $db->loadResult();
	if ($tip == 0) {
		if ($anunt_id == '') {
			$query = "UPDATE #__sa_comentarii SET `readed_c` = '1' WHERE  `proprietar` = '".$uid."'";
		} else {
			$query = "UPDATE #__sa_comentarii SET `readed_c` = '1' WHERE  `proprietar` = '".$uid."' AND `anunt_id` = '".$anunt_id."'";	
		}
	} else {
		if ($anunt_id == '') {
			$query = "UPDATE #__sa_comentarii SET `readed_d` = '1' WHERE  `companie` = '".$uid."'";
		} else {
			$query = "UPDATE #__sa_comentarii SET `readed_d` = '1' WHERE  `companie` = '".$uid."' AND `anunt_id` = '".$anunt_id."'";
		}
	}
	$db->setQuery($query);
	//echo '>>>> '.$anunt_id;
	$db->query();
	$app->redirect($link_redirect, JText::_('SAUTO_ALL_COMMS_MARK_AS_READED'));
}
	
		
?>

