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
$user =& JFactory::getUser();
$uid = $user->id;
$app =& JFactory::getApplication();

$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$return =& JRequest::getVar( 'return', '', 'post', 'string' );
$original =& JRequest::getVar( 'original', '', 'post', 'string' );
$db = JFactory::getDbo();

$query = "SELECT count(*) FROM #__sa_facturi WHERE `uid` = '".$uid."' AND `id` = '".$id."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 1) {
$query = "UPDATE #__sa_facturi SET `original` = '1' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
	if ($return == 'lista') {
		$link_redirect = JRoute::_('index.php?option=com_sauto&view=facturi');
	} elseif ($return == 'facturi') {
		$link_redirect = JRoute::_('index.php?option=com_sauto&amp;view=edit_profile#tab4');
	}
$app->redirect($link_redirect, JText::_('SAUTO_FACTURA_SOLICITATA_CU_SUCCES'));
} else {
$link_redirect = JRoute::_('index.php?option=com_sauto');
$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));	
}


