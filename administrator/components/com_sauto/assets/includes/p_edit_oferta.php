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
$raspuns_id =& JRequest::getVar( 'raspuns_id', '', 'post', 'string' );
$pret =& JRequest::getVar( 'pret', '', 'post', 'string' );
$moneda =& JRequest::getVar( 'moneda', '', 'post', 'string' );
$oferta =& JRequest::getVar( 'oferta', '', 'post', 'string', JREQUEST_ALLOWHTML  );
$anunt_id =& JRequest::getVar( 'anunt_id', '', 'post', 'string' );

$db = JFactory::getDbo();
if ($pret == '') {
	$upd_pret = '';
} else {
	$upd_pret = ", `pret_oferit` = '".$pret."'";
}
if ($oferta == '') {
	$upd_oferta = '';
} else {
	$upd_oferta = ", `mesaj` = '".$oferta."'";
}
$query = "UPDATE #__sa_raspunsuri SET `moneda` = '".$moneda."' ".$upd_pret." ".$upd_oferta." WHERE `id` = '".$raspuns_id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=anunt&id='.$anunt_id;
$app->redirect($redirect, 'Oferta facuta de catre firma a fost modificata cu succes');
