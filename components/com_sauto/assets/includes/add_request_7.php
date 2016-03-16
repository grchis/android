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
$app =& JFactory::getApplication();
$db = JFactory::getDbo();

$link_redirect = JRoute::_('index.php?option=com_sauto&view=new_request');

$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$acc =& JRequest::getVar( 'acc', '', 'post', 'string' );
$subacc =& JRequest::getVar( 'subacc', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt7', '', 'post', 'string', JREQUEST_ALLOWHTML );
$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$expiryDate = date('Y-m-d H:i:s', ($time+2592000));	

if ($acc == '') {
	//nu am selectat accesoriu
	$app->redirect($link_redirect, JText::_('SAUTO_NO_ACC_ADDED'));
} else {
	//accesoriu existent, obtinem id-ul
	$query = "SELECT `id` FROM #__sa_accesorii WHERE `accesorii` = '".$acc."'";
	$db->setQuery($query);
	$acc_id = $db->loadResult();
	$app->setUserState('accesorii', $acc_id);	
	$app->setUserState('subaccesorii', $subacc);
}

if ($marca != '') {
	$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
	$db->setQuery($query);
	$mid = $db->loadResult();
}
//introducem in tabela temporara

$query = "INSERT INTO #__sa_temporar (`titlu_anunt`, `anunt`, `tip_anunt`, `accesorii_auto`, `subaccesorii_auto`, 
		`data_adaugarii`, `status_anunt`, `marca_auto`, `model_auto`) 
		VALUES 
		('".$titlu_anunt."', '".$anunt."', '7', '".$acc_id."', '".$subacc."', '".$curentDate."', '1', '".$mid."', '".$model_auto."')";
$db->setQuery($query);
$db->query();
$anunt_id = $db->insertid();
//setez variabilele
$app->setUserState('anunt_id', $anunt_id);

