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

$stare =& JRequest::getVar( 'stare', '', 'post', 'string' );


$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_stare_auto (`stare`) VALUES ('".$stare."')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=stare';
$app->redirect($redirect, 'Stare auto adaugata cu succes');	
