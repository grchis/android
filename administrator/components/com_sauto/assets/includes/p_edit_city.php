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

$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$city =& JRequest::getVar( 'city', '', 'post', 'string' );
$aprove =& JRequest::getVar( 'aprove', '', 'post', 'string' );
$return_link =& JRequest::getVar( 'return_link', '', 'post', 'string' );

if ($aprove == 1) {
	$upd = ", `published` = '1'";
} else { $upd = ''; }

$db = JFactory::getDbo();
$query = "UPDATE #__sa_localitati SET `localitate` = '".$city."' ".$upd." WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
//redirect
$app =& JFactory::getApplication();
if ($aprove == 1) {
$app->redirect($return_link, 'Localitate editata si aprobata cu succes');	
} else {
$app->redirect($return_link, 'Localitate editata cu succes');
}
