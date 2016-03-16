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
	$db = JFactory::getDbo();
	//echo '>>>>> '.$rezult->subaccesorii_auto;
	//accesoriu
	if ($rezult->accesorii_auto != 0) {
		$query = "SELECT `accesorii` FROM #__sa_accesorii WHERE `id` = '".$rezult->accesorii_auto."'";
		$db->setQuery($query);
		$acc = $db->loadResult();
		echo JText::_('SAUTO_TIP_ACCESORIU').': '.$acc.'<br />';
	}
	//subaccesoriu
	
	if ($rezult->subaccesorii_auto != 0) {
		$query = "SELECT `subaccesoriu` FROM #__sa_subaccesorii WHERE `id` = '".$rezult->subaccesorii_auto."'";
		$db->setQuery($query);
		$subacc = $db->loadResult();
		echo JText::_('SAUTO_TIP_SUBACCESORIU').': '.$subacc.'<br />';
	}
	//afisez marca
	if ($rezult->marca_auto != 0) {
		$query = "SELECT `marca_auto` FROM #__sa_marca_auto WHERE `id` = '".$rezult->marca_auto."'";
		$db->setQuery($query);
		$marca = $db->loadResult();
		echo JText::_('SAUTO_MARCA').': ';
		echo $marca;
		echo '<br />';
	}
	//afisez modelul
	if ($rezult->model_auto != 0) {
		$query = "SELECT `model_auto` FROM #__sa_model_auto WHERE `id` = '".$rezult->model_auto."'";
		$db->setQuery($query);
		$model = $db->loadResult();
		echo JText::_('SAUTO_MODEL').': ';
		echo $model;
		echo '<br />';
	}
}
?>
