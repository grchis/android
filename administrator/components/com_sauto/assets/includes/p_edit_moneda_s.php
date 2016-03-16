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

$m_scurt =& JRequest::getVar( 'm_scurt', '', 'post', 'string' );
$id =& JRequest::getVar( 'id', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "UPDATE #__sa_moneda SET `m_scurt` = '".$m_scurt."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();

$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=moneda';
$app->redirect($redirect, 'Prescurtarea monedei a fost editata cu succes');	
