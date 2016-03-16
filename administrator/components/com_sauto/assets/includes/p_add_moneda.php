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

$m_lung =& JRequest::getVar( 'm_lung', '', 'post', 'string' );
$m_scurt =& JRequest::getVar( 'm_scurt', '', 'post', 'string' );


$db = JFactory::getDbo();
$query = "INSERT INTO #__sa_moneda (`m_lung`, `m_scurt`, `published`) VALUES ('".$m_lung."', '".$m_scurt."', '1')";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=moneda';
$app->redirect($redirect, 'Moneda adaugata cu succes');	
