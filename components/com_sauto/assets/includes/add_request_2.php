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
$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );

$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt2', '', 'post', 'string', JREQUEST_ALLOWHTML );
$time = time();
$curentDate = date('Y-m-d H:i:s', $time);
$expiryDate = date('Y-m-d H:i:s', ($time+2592000));	

//get id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
$db->setQuery($query);
$judet = $db->loadResult();
$data_preluare =& JRequest::getVar( 'data_preluare', '', 'post', 'string' );
$data_returnare =& JRequest::getVar( 'data_returnare', '', 'post', 'string' );

$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();
//introducem in tabela temporara

$query = "INSERT INTO #__sa_temporar (`titlu_anunt`, `anunt`, `tip_anunt`,   `caroserie`,  `proprietar`, `data_adaugarii`, `status_anunt`, `raportat`, `data_expirarii`, `judet`, `city`, `data_preluare`, `data_returnare`, `judet_r`, `localitate_r`) VALUES ('".$titlu_anunt."', '".$anunt."', '2', '".$caroserie."', '0', '".$curentDate."', '1', '0', '".$expiryDate."', '".$judet."', '".$city."', '".$data_preluare."', '".$data_returnare."', '".$judet_r_id."', '".$localitate_r."')";
$db->setQuery($query);
$db->query();
$anunt_id = $db->insertid();
//setez variabilele
$app->setUserState('anunt_id', $anunt_id);

