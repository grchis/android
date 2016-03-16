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
	//marca
	$query = "SELECT `marca_auto`, `published` FROM #__sa_marca_auto WHERE `id` = '".$rezult->marca_auto."'";
	$db->setQuery($query);
	$marca = $db->loadObject();
	if ($marca != '') {
		echo JText::_('SAUTO_MARCA').': ';
				if ($marca->published == 1) {
					echo $marca->marca_auto;
				} else {
					echo '<span class="sa_unpublished">';
					echo $marca->marca_auto;
					echo '</span>';
				}
		echo '<br />';
	}
	//model
	$query = "SELECT `model_auto`, `published` FROM #__sa_model_auto WHERE `id` = '".$rezult->model_auto."'";
	$db->setQuery($query);
	$model = $db->loadObject();
	if ($model != '') {
		echo JText::_('SAUTO_MODEL').': ';
				if ($model->published == 1) {
					echo $model->model_auto;
				} else {
					echo '<span class="sa_unpublished">';
					echo $model->model_auto;
					echo '</span>';
				}
		echo '<br />';
	}
	//an fabricatie
	if ($rezult->an_fabricatie != '') {
		echo JText::_('SAUTO_ANUL_FABR').': '.$rezult->an_fabricatie.'<br />';
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
	

}
?>
