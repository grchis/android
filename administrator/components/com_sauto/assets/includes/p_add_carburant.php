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

$carburant =& JRequest::getVar( 'carburant', '', 'post', 'string' );


$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_carburant (`carburant`) VALUES ('".$carburant."')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=carburant';
$app->redirect($redirect, 'Carburant adaugat cu succes');	
