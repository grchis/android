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
$return_link =& JRequest::getVar( 'return_link', 'post', 'string' );

$db = JFactory::getDbo();
$app =& JFactory::getApplication();

if ($tip == 'unpublish') {
	//unpublish
	$query = "UPDATE #__sa_localitati SET `published` = '0' WHERE `id` = '".$id."'";
	$mesaj_redirect = JText::_('Localitatea nu mai este publica');
} else {
	//publish
	$query = "UPDATE #__sa_localitati SET `published` = '1' WHERE `id` = '".$id."'";
	$mesaj_redirect = JText::_('Localitatea este publicata');
}
$db->setQuery($query);
$db->query();

$app->redirect($return_link, $mesaj_redirect);
?>

