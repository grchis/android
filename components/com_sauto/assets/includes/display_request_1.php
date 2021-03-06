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
$marca;

function getMarca () {
	$db = JFactory::getDbo();
	//marca
	$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$rezult->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadObject();
}
function view_detail($rezult, $tip) {
	$db = JFactory::getDbo();
	//marca
	$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$rezult->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadObject();
	if ($marca != '') {
		echo JText::_('SAUTO_MARCA').': ';
		echo $marca->marca_auto;
		echo '<br />';
	}
	//model	
	$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$rezult->model_auto."'";
	$db->setQuery($query);
	$model = $db->loadObject();
	if ($model != '') {
		echo JText::_('SAUTO_MODEL').': ';
		echo $model->model_auto; 
		echo '<br />';
	}
	//an fabricatie
	if ($rezult->an_fabricatie != '') {
		echo JText::_('SAUTO_ANUL_FABR').': '.$rezult->an_fabricatie.'<br />';
	}
	//serie caroserie
	if ($rezult->serie_caroserie != '') {
		echo JText::_('SAUTO_SERIE_CAROS').': '.$rezult->serie_caroserie.'<br />';
	}
	
	//carburant
	$query = "SELECT `carburant` FROM #__sa_carburant WHERE `id` = '".$rezult->carburant."'";
	$db->setQuery($query);
	$carburant = $db->loadResult();
	if ($carburant != '') {
		echo JText::_('SAUTO_CARB').': '.$carburant.'<br />';
	}
	//cilindree
	if ($rezult->cilindree != '') {
		echo JText::_('SAUTO_CILINDR').': '.$rezult->cilindree.' '.JText::_('SAUTO_CILINDR_UM').'<br />';
	}
	//transmisie	
	$query = "SELECT `transmisie` FROM #__sa_transmisie WHERE `id` = '".$rezult->transmisie."'";	
	$db->setQuery($query);	
	$trm = $db->loadResult();	
	//echo '>>>> '.$trm;	
	if ($trm != '') {		
	echo JText::_('SAUTO_TIP_TRANSMISIE').': '.$trm.'<br />';	
	}	
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
	
	echo JText::_('SAUTO_VREAU_PIESA_NOUA').': ';
	if ($rezult->nou == 1) {
		echo JText::_('SAUTO_ALERT_YES'); 
	} else {
		echo JText::_('SAUTO_ALERT_NO'); 
	}
	echo '<br />';
	
	echo JText::_('SAUTO_VREAU_PIESA_SH').': ';
	if ($rezult->sh == 1) {
		echo JText::_('SAUTO_ALERT_YES'); 
	} else {
		echo JText::_('SAUTO_ALERT_NO'); 
	}
	echo '<br />';	
}
?>
