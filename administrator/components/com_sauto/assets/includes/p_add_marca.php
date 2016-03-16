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

$marca =& JRequest::getVar( 'marca', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_marca_auto (`marca_auto`, `published`) VALUES ('".$marca."',  '1')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=marci';
$app->redirect($redirect, 'Marca auto adaugata cu succes');	
