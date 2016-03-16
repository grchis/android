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

$app =& JFactory::getApplication();
$id =& JRequest::getVar( 'id', '', 'get', 'string' );

$query = "SELECT count(*) FROM #__sa_garaj WHERE `id` = '".$id."' AND `owner` = '".$uid."'";
$db->setQuery($query);
$total = $db->loadResult();
if ($total == 0) {
	//redirect
	$link_redirect = JRoute::_('index.php?option=com_sauto');
	$app->redirect($link_redirect, JText::_('SAUTO_PAGE_NOT_EXIST'));
} else {
	$query = "DELETE FROM #__sa_garaj WHERE `id` = '".$id."' AND `owner` = '".$uid."'";
	$db->setQuery($query);
	$db->query();
	$link_redirect = JRoute::_('index.php?option=com_sauto&view=garaj');
	$app->redirect($link_redirect, JText::_('SAUTO_SUCCES_DELETE_FROM_GARAJ'));
}
