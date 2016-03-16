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

function view_detail($rezult, $tip) {
	$user =& JFactory::getUser();
	$uid = $user->id;
	//echo '>>>> '.$uid.' ??? '.$rezult->proprietar;
	$db = JFactory::getDbo();
	//judet
	$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$rezult->judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	if ($judet != '') {
		echo JText::_('SAUTO_FORM_REGION_PRELUARE').': '.$judet.'<br />';
	}
	//city
	$query = "SELECT `localitate`, `published` FROM #__sa_localitati WHERE `id` = '".$rezult->city."'";
	$db->setQuery($query);
	$city = $db->loadObject();
	if ($city->localitate != '') {
		if ($city->published == 1) {
		echo JText::_('SAUTO_FORM_CITY_PRELUARE').': '.$city->localitate.'<br />';
		} else {
			if ($rezult->proprietar == $uid) {
			echo JText::_('SAUTO_FORM_CITY_PRELUARE').': '.$city->localitate.'<br />';	
			echo JText::_('SAUTO_DISPLAY_PENDING_CITY').' ';
			}
		} 

	}
	//data preluarii
	echo JText::_('SAUTO_DATA_PRELUARE').': ';
	$data_p = explode(" ", $rezult->data_preluare);
	echo $data_p[0].'<br />';
	
	//judet returnare
	$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$rezult->judet_r."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	if ($judet != '') {
		echo JText::_('SAUTO_FORM_REGION_RETURNARE').': '.$judet.'<br />';
	}
	//localitate returnare
	$query = "SELECT `localitate`, `published` FROM #__sa_localitati WHERE `id` = '".$rezult->localitate_r."'";
	$db->setQuery($query);
	$city = $db->loadObject();
	if ($city->localitate != '') {
		if ($city->published == 1) {
		echo JText::_('SAUTO_FORM_CITY_RETURNARE').': '.$city->localitate.'<br />';
		} else {
			if ($rezult->proprietar == $uid) {
			echo JText::_('SAUTO_FORM_CITY_RETURNARE').': '.$city->localitate.'<br />';	
			echo JText::_('SAUTO_DISPLAY_PENDING_CITY').' ';
			}
		} 

	}
	//data returnarii
	echo JText::_('SAUTO_DATA_RETURNARE').': ';
	$data_r = explode(" ", $rezult->data_returnare);
	echo $data_r[0].'<br />';
	//caroserie
	$query = "SELECT `caroserie` FROM #__sa_caroserie WHERE `id` = '".$rezult->caroserie."'";
	$db->setQuery($query);
	$caroserie = $db->loadResult();
	if ($caroserie != '') {
		echo JText::_('SAUTO_CAROS').': '.$caroserie.'<br />';
	}
	
	
	
}
?>
