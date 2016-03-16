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
$anunt =& JRequest::getVar( 'anunt5', '', 'post', 'string', JREQUEST_ALLOWHTML );
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$judet = $db->loadResult();


$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();

$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );
$model_auto =& JRequest::getVar( 'model_auto', '', 'post', 'string' );

$query = "SELECT `id` FROM #__sa_marca_auto WHERE `marca_auto` = '".$marca."'";
$db->setQuery($query);
$mid = $db->loadResult();
	
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$expiryDate = date('Y-m-d H:i:s', ($time+2592000));	

//introducem in tabela temporara

$query = "INSERT INTO #__sa_temporar (`titlu_anunt`, `anunt`, `tip_anunt`,   `marca_auto`,  `model_auto`, `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `judet`, `city`,  `judet_r`, `localitate_r`) VALUES ('".$titlu_anunt."', '".$anunt."', '5', '".$mid."', '".$model_auto."', '0', '".$curentDate."', '1', '0', '".$expiryDate."', '".$judet."', '".$city."', '".$judet_r_id."', '".$localitate_r."')";
$db->setQuery($query);
$db->query();
$anunt_id = $db->insertid();
//setez variabilele
$app->setUserState('anunt_id', $anunt_id);
