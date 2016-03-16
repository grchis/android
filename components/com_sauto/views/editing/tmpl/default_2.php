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
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();
$link_redirect = JRoute::_('index.php?option=com_sauto&view=my_request');

$id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );
$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt1', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );

$data_preluare =& JRequest::getVar( 'data_preluare', '', 'post', 'string' );
$data_returnare =& JRequest::getVar( 'data_returnare', '', 'post', 'string' );
$judet_r =& JRequest::getVar( 'judet_r', '', 'post', 'string' );
$localitate_r =& JRequest::getVar( 'localitate_r', '', 'post', 'string' );
//obtin id judet
$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet_r."'";
$db->setQuery($query);
$judet_r_id = $db->loadResult();

$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );
$new_city =& JRequest::getVar( 'new_city', '', 'post', 'string' );

if ($judet == '') {
	$upd_judet = '';
} else {
	//obtin id de judet
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$jid = $db->loadResult();
	$upd_judet = " `judet` = '".$jid."', ";
	
	if ($new_city == '') {
	//nu avem localitate noua
	//verificam daca avem localitatea setata
		if ($city == '') {
			//nu e aleasa
			$upd_city = '';
		} else {
			//e aleasa
			$upd_city = " `city` = '".$city."', ";
		} 
	} else {
	//adaugam localitate noua
	$query = "INSERT INTO #__sa_localitati (`jid`, `localitate`, `published`) VALUES ('".$jid."', '".$new_city."', '0')";
	$db->setQuery($query);
	$db->query();
	$nc_id = $db->insertid();
	$upd_city = " `city` = '".$nc_id."', ";
	}
}
//echo '>> judet = '.$judet.' >>> city > '.$city.' >>>> new city > '.$new_city;


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
$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_anunt."  ".$upd_judet." ".$upd_city."  `caroserie` = '".$caroserie."', `data_preluare` = '".$data_preluare."', `data_returnare` = '".$data_returnare."', `judet_r` = '".$judet_r_id."', `localitate_r` = '".$localitate_r."' WHERE `proprietar` = '".$uid."' AND `id` = '".$id."'";
$db->setQuery($query);
$db->query();

//redirectionare
$app->redirect($link_redirect, JText::_('SAUTO_ANUNT_UPDATED_SUCCESSFULY'));
?>

 
