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
$return_link =& JRequest::getVar( 'return_link', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "DELETE FROM #__sa_model_auto WHERE `mid` = '".$id."'";
$db->setQuery($query);
$db->query();

$query = "DELETE FROM #__sa_marca_auto WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$app->redirect($return_link, 'Marca auto eliminata cu succes');	
