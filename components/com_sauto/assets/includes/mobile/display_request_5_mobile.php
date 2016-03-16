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

	//marca masina
	$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$rezult->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadObject();
	if ($marca != '') {
		echo JText::_('SAUTO_MARCA').': ';
			if ($tip == 'dealer') {
				if ($marca->published == 1) {
					echo $marca->marca_auto;
				} else {
					echo JText::_('SAUTO_MARCA_NEPUBLICATA');
				}
			} else {
				if ($marca->published == 1) {
					echo $marca->marca_auto;
				} else {
					echo '<span class="sa_unpublished">';
					echo $marca->marca_auto;
					echo '</span>';
				}
			}
		echo '<br />';
	}
	//model masina
	$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$rezult->model_auto."'";
	$db->setQuery($query);
	$model = $db->loadObject();
	if ($model != '') {
		echo JText::_('SAUTO_MODEL').': ';
			if ($tip == 'dealer') {
				if ($model->published == 1) {
					echo $model->model_auto;
				} else {
					echo JText::_('SAUTO_MODEL_NEPUBLICAT');
				}
			} else {
				if ($model->published == 1) {
					echo $model->model_auto;
				} else {
					echo '<span class="sa_unpublished">';
					echo $model->model_auto;
					echo '</span>';
				}
			}
		echo '<br />';
	}
	//judet returnare
	$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$rezult->judet_r."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	if ($judet != '') {
		echo JText::_('SAUTO_FORM_REGION_DESTINATIE').': '.$judet.'<br />';
	}
	//localitate returnare
	$query = "SELECT `localitate`, `published` FROM #__sa_localitati WHERE `id` = '".$rezult->localitate_r."'";
	$db->setQuery($query);
	$city = $db->loadObject();
	if ($city->localitate != '') {
		if ($city->published == 1) {
		echo JText::_('SAUTO_FORM_CITY_DESTINATIE').': '.$city->localitate.'<br />';
		} else {
			if ($rezult->proprietar == $uid) {
			echo JText::_('SAUTO_FORM_CITY_DESTINATIE').': '.$city->localitate.'<br />';	
			echo JText::_('SAUTO_DISPLAY_PENDING_CITY').'<br />';
			}
		} 

	}
	
}
?>
