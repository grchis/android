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

function view_detail($rezult) {
	$db = JFactory::getDbo();
	//judet
	$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$rezult->judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	if ($judet != '') {
		echo JText::_('SAUTO_DISPLAY_JUDET').': '.$judet.'<br />';
	}
	//city
		$query = "SELECT `localitate`, `published` FROM #__sa_localitati WHERE `id` = '".$rezult->city."'";
	$db->setQuery($query);
	$city = $db->loadObject();
	if ($city->localitate != '') {
		if ($city->published == 1) {
		echo JText::_('SAUTO_DISPLAY_CITY').': '.$city->localitate.'<br />';
		} else {
			echo JText::_('SAUTO_DISPLAY_CITY').': '.$city->localitate.'<br />';	
			echo JText::_('SAUTO_DISPLAY_PENDING_CITY').'<br />';
		} 

	}

	//caroserie
	$query = "SELECT `caroserie` FROM #__sa_caroserie WHERE `id` = '".$rezult->caroserie."'";
	$db->setQuery($query);
	$caroserie = $db->loadResult();
	if ($caroserie != '') {
		echo JText::_('SAUTO_CAROS').': '.$caroserie.'<br />';
	}

}
?>
