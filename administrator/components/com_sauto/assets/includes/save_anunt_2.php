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
//obtin id anunt
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$db = JFactory::getDbo();

$titlu_anunt =& JRequest::getVar( 'titlu_anunt', '', 'post', 'string' );
$anunt =& JRequest::getVar( 'anunt2', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );


$judet =& JRequest::getVar( 'judet', '', 'post', 'string' );
$city =& JRequest::getVar( 'localitate', '', 'post', 'string' );

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

if ($judet == '') {
	$upd_judet = '';
} else {
	//obtinem id judet
	$query = "SELECT `id` FROM #__sa_judete WHERE `judet` = '".$judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	$upd_judet = " `judet` = '".$judet."', ";
}
if ($city == '') {
	$upd_city = '';
} else {
	$upd_city = " `city` = '".$city."', ";
}
//echo '>>> '.$judet.' >>>> '.$city;

$query = "UPDATE #__sa_anunturi SET ".$upd_titlu_anunt." ".$upd_anunt."  ".$upd_judet." ".$upd_city."  `caroserie` = '".$caroserie."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$link_redirect = 'index.php?option=com_sauto&task=anunturi';
$app->redirect($link_redirect, 'Anuntul a fost editat cu succes');
