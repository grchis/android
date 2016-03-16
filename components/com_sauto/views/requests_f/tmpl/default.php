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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$cat =& JRequest::getVar( 'cat', '', 'get', 'string' );
$task =& JRequest::getVar( 'task', '', 'get', 'string' );
if ($id != '') {
	$id_var = '&id='.$id;
} else {
	$id_var = '';
}
if ($cat == 1) {
	$link_ok = JRoute::_('index.php?option=com_sauto&view=categories'.$id_var);
} else {
	if ($task == '') {
	$link_ok = JRoute::_('index.php?option=com_sauto&view=requests'.$id_var);
	} elseif ($task == 'my') {
	$link_ok = JRoute::_('index.php?option=com_sauto&view=my_request');
	} elseif ($task == 'final') {
	$link_ok = JRoute::_('index.php?option=com_sauto&view=final_request');
	}
}
$user =& JFactory::getUser();
$uid = $user->id;
$permit = 0;
	if ($uid == 0) {
		//vizitator
		//$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		$permit = 1;
		//echo 'guest...';
	} else {
		//verificare tip utilizator
		$query= "SELECT `tip_cont` FROM #__sa_profiles WHERE `uid` = '".$uid."'";
		$db->setQuery($query);
		$tip = $db->loadResult();
		if ($tip == 0) {
			//client
			$permit = 1;
		} elseif ($tip == 1) {
			//dealer
			//resetare 
			$permit = 1;
		} else {
			//nedefinit, redirectionam la prima pagina
			$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
		} 
	}


	if ($permit == 1) {
		$app->setUserState('marci', '');
		$app->setUserState('modele', '');
		$app->setUserState('judete', '');
		$app->setUserState('oferte', '');
		$app->setUserState('orase', '');
		$app->setUserState('piese', '');
		$app->redirect($link_ok);
	}
