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

$model =& JRequest::getVar( 'model', '', 'post', 'string' );
$id =& JRequest::getVar( 'id', '', 'post', 'string' );
$return_link =& JRequest::getVar( 'return_link', '', 'post', 'string' );
$aprove =& JRequest::getVar( 'aprove', '', 'post', 'string' );

if ($aprove == 1) {
	$upd_aprove = ", `published` = '1' ";
} else {
	$upd_aprove = '';
}
$db = JFactory::getDbo();
$query = "UPDATE #__sa_model_auto SET `model_auto` = '".$model."' ".$upd_aprove." WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$app->redirect($return_link, 'Model auto editat cu succes');
