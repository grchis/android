<?php
/**
 * @package    sauto
 * @subpackage Base
 * @author     Dacian Strain {@link http://shop.elbase.eu}
 * @author     Created on 17-Nov-2013
 * @license    GNU/GPL
 */

//-- No direct access
defined('_JEXEC') || die('=;)');
$tip =& JRequest::getVar( 'tip', 'post', 'string' );
$id =& JRequest::getVar( 'id', '', 'post', 'string' );

$db = JFactory::getDbo();
$app =& JFactory::getApplication();

if ($tip == 'unpublish') {
	//unpublish
	$query = "UPDATE #__sa_reclame SET `published` = '0' WHERE `id` = '".$id."'";
	$mesaj_redirect = JText::_('Reclama nu mai este publicata');
} else {
	//publish
	$query = "UPDATE #__sa_reclame SET `published` = '1' WHERE `id` = '".$id."'";
	$mesaj_redirect = JText::_('Reclama este publicata');
}
$db->setQuery($query);
$db->query();

$redirect = 'index.php?option=com_sauto&task=setari&action=reclame';
$app->redirect($redirect, $mesaj_redirect);
?>
