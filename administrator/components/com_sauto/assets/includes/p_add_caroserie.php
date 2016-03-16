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

$caroserie =& JRequest::getVar( 'caroserie', '', 'post', 'string' );


$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_caroserie (`caroserie`) VALUES ('".$caroserie."')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=caroserie';
$app->redirect($redirect, 'Caroserie adaugata cu succes');	
