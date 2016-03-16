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
	//marca
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
	//model
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
	//obtinem judet
	$query = "SELECT `judet` FROM #__sa_judete WHERE `id` = '".$rezult->judet."'";
	$db->setQuery($query);
	$judet = $db->loadResult();
	echo JText::_('SAUTO_FORM_REGION').' '.$judet.'<br />';
	
	//obtinem localitatea
	$query = "SELECT `localitate` FROM #__sa_localitati WHERE `id` = '".$rezult->city."'";
	$db->setQuery($query);
	$city = $db->loadResult(); 
	echo JText::_('SAUTO_FORM_CITY').' '.$city.'<br />';
	

	//cilindree
	if ($rezult->cilindree != '') {
		echo JText::_('SAUTO_CILINDR').': '.$rezult->cilindree.' '.JText::_('SAUTO_CILINDR_UM').'<br />';
	}
	//carburant
	$query = "SELECT `carburant` FROM #__sa_carburant WHERE `id` = '".$rezult->carburant."'";
	$db->setQuery($query);
	$carburant = $db->loadResult();
	if ($carburant != '') {
		echo JText::_('SAUTO_CARB').': '.$carburant.'<br />';
	}
	//transmisie
	echo JText::_('SAUTO_TIP_TRANSMISIE').': ';
	if ($rezult->transmisie == 1) {
		echo JText::_('SAUTO_TRANSMISIE_MANUALA'); 
	} elseif ($rezult->transmisie == 2) {
		echo JText::_('SAUTO_TRANSMISIE_AUTOMATA'); 
	} elseif ($rezult->transmisie == 0) {
		echo JText::_('SAUTO_NECOMPLECTAT'); 
	}
	echo '<br />';
	//caroserie
	$query = "SELECT `caroserie` FROM #__sa_caroserie WHERE `id` = '".$rezult->caroserie."'";
	$db->setQuery($query);
	$caroserie = $db->loadResult();
	if ($caroserie != '') {
		echo JText::_('SAUTO_CAROS').': '.$caroserie.'<br />';
	}
	//nr usi
	$query = "SELECT `usi` FROM #__sa_usi WHERE `id` = '".$rezult->nr_usi."'";
	$db->setQuery($query);
	$usi = $db->loadResult();
	if ($usi != '') {
		echo JText::_('SAUTO_USI').': '.$usi.'<br />';
	}
}
?>
