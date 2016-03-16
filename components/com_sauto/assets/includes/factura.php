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
$id =& JRequest::getVar( 'id', '', 'get', 'string' );
$type =& JRequest::getVar( 'type', '', 'get', 'string' );
//verificam daca este factura proprie
if ($type == 'fact') {
	$upd_q = ' AND `status_tr` = \'1\' ';
} elseif ($type == 'prf') {
	$upd_q = ' AND `status_tr` = \'0\' ';
} else {
	$upd_q = ' AND `status_tr` = \'2\' ';
}
$upd_id = " AND `id` = '".$id."'";
$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' ".$upd_q." ".$upd_id." ";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
	//pagina inexistenta
	$app =& JFactory::getApplication();
	$link_redirect = JRoute::_('index.php?option=com_sauto&view=facturi');
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
	//vezi factura in funtie de type
	if ($type == 'fact') {
		require("factura_fact.php");
	} elseif ($type == 'prf') {
		require("factura_prf.php");
	}
}
?>

