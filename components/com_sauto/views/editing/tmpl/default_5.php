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
$db = JFactory::getDbo();
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto&view=my_request');

$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt5', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );

$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$jid = $db->loadResult();

$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
$db->setQuery($query);
$mid = $db->loadResult();
		
		
if ($titlu_anunt == '') {
	$upd_titlu_anunt = '';
} else {
	$upd_titlu_anunt = " `titlu_anunt` = '".$titlu_anunt."', "; 
}
if ($anunt == '') {
	$upd_anunt = '';
} else {
	$upd_anunt = " `anunt` = '".$anunt."', ";
}

//actualizam anuntul
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_anunt."  `judet` = '".$jid."', `city` = '".$city."', `judet_r` = '".$judet_r_id."', `localitate_r` = '".$localitate_r."', `marca_auto` = '".$mid."', `model_auto` = '".$model_auto."' WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
$db->setQuery($query);
$db->query();

//redirectionare
$app->redirect($link_redirect, JText::_('SAUTO_ANUNT_UPDATED_SUCCESSFULY'));
