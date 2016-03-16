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

$usi =& JRequest::getVar( 'usi', '', 'post', 'string' );


$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_usi (`usi`) VALUES ('".$usi."')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=usi';
$app->redirect($redirect, 'Nr. usi adaugate cu succes');	
