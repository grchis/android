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
$procesator =& JRequest::getVar( 'procesator', '', 'post', 'string' );

$db = JFactory::getDbo();
$query = "UPDATE #__sa_plati SET `procesator` = '".$procesator."' WHERE `id` = '".$id."'";
$db->setQuery($query);
$db->query();
//redirect
$app =& JFactory::getApplication();
$redirect = 'index.php?option=com_sauto&task=setari&action=plati';
$app->redirect($redirect, 'Procesatorul de plati a fost editat cu succes');	

